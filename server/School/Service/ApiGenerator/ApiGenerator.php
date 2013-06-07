<?php

class School_Service_ApiGenerator_ApiGenerator 
implements 
    School_Service_Interface_ApiGenerator 
{

    /** @var string Путь к корневой директории приложения */
    private $rootDirectory;

    /** @var string Путь к файлу с API для использования клиентом */
    private $javascriptApiFile;

    /** @var string Путь к файлу с API для использования сервером */
    private $phpApiFile;

    /** @var string Путь к директории контроллеров */
    private $controllerDirectory;

    /** @var string Общее название пространства имён для клиента и сервера */
    private $commonNamespace;
    
    /**
     * Названия служебных директорий, которые не должны попасть в API
     * @var array 
     */
    private $skippedDeirectories;
        
    private $siteRootOffset;
    
    /**
     * Имя директории с файлами API
     * @var string 
     */
    private $apiDirectory;
    
    /**
     * Части корневого пространства имен серверного приложения
     * @var array
     */
    private $phpRootNamespaceParts;
    
    private $formHandlerParameterName;

    /**
     * Конструктор сервиса
     */
    public function __construct($siteRootOffset = '') {
        
        $this->formHandlerParameterName = 'formHandler';
        
        $this->phpRootNamespaceParts = explode('_', 'School');

        $this->commonNamespace = 'remote';
        $this->rootDirectory = dirname(dirname(dirname(dirname(__FILE__))));
        
        $this->apiDirectory = $this->rootDirectory.'/'.'api';

        if (!is_writable($this->apiDirectory)) {
            throw new School_Service_ApiGenerator_Exception('У PHP нет прав на запись в директорию '.$this->apiDirectory);
        }

        $this->controllerDirectory = $this->rootDirectory.'/'.$this->getCommonNamespaceOnServer();
        $this->javascriptApiFile = $this->apiDirectory.'/api.js';
        $this->phpApiFile = $this->apiDirectory.'/api.php';
        $this->skippedDeirectories = array('Abstract', 'Interface');
        
        $this->siteRootOffset = $siteRootOffset;

    }

    public function generate() {

        $classes = $this->globRecursive($this->controllerDirectory.'/*.php');

        $actions = array();

        foreach ($classes as $namespace => $classNames) {
            
            // проверяем на на наличие в директории файла main.php
            if (!in_array('main', $classNames)) {
                throw new School_Service_ApiGenerator_Exception('В директории для '.$namespace.' не хватает файла main.php');
            }

            foreach ($classNames as $className) {

                // пропускаем подключение точки входа в систему server/main.php
                if ($className == 'main') {
                    continue;
                }
                
                
                $class = $namespace . '_' . $className;

                if (!class_exists($class, true)) {
                    throw new School_Service_ApiGenerator_Exception('Класс для обработки RPC-вызовов не обнаружен: ' . $class);
                }
                
                $methods =  $this->getClassMethods($class);
                if (!empty($methods)) {
                    $actions[$namespace][$className] = $methods;
                }

            }

        }

        // Сохраняем текст API в файлы

        $javascriptApi = $this->buildJavascript($actions);
        file_put_contents($this->javascriptApiFile, $javascriptApi);

        $phpApi =$this->buildPhp($actions);
        file_put_contents($this->phpApiFile, $phpApi);
        
        // Проверяем возможность писать в файлы
        
        if(!is_writable($this->javascriptApiFile)) {
            throw new School_Service_ApiGenerator_Exception('Не возможно изменить файл '.$this->javascriptApiFile);
        }
        
        if(!is_writable($this->phpApiFile)) {
            throw new School_Service_ApiGenerator_Exception('Не возможно изменить файл '.$this->phpApiFile);
        }

    }
    
    private function getCommonNamespaceOnServer() {
        
        return implode('/', $this->phpRootNamespaceParts).'/'.ucfirst($this->commonNamespace);
        
    }
    
    private function getCommonNamespaceOnClient() {
        
        return $this->commonNamespace;
        
    }

    private function getClassMethods($className) {

        $methods = array();

        $classReflection = new ReflectionClass($className);

        // Получаем открытые методы класса
        $publicMethodReflections = $classReflection->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($publicMethodReflections as $publicMethodReflection) {

            $methodName = $publicMethodReflection->name;

            // исключаем специальные и волшебные методы
            if (strlen($methodName) > 2 && substr($methodName, 0, 2) == '__') {
                continue;
            }

            // исключаем статические методы
            if ($publicMethodReflection->isStatic()) {
                continue;
            }

            $methods[$methodName] = array(
                'length' => $publicMethodReflection->getNumberOfParameters(),
                'parameters' => $this->getMethodParameters($publicMethodReflection)
            );

        }

        return $methods;

    }

    private function getMethodParameters(ReflectionMethod $method_reflection) {

        $parameters = array();

        $parameterReflections = $method_reflection->getParameters();

        foreach ($parameterReflections as $parameterReflection) {
            
            // пропускаем служебный параметр $formHandler = true
            if ($parameterReflection->getName() == $this->formHandlerParameterName) {
                continue;
            }

            if ($parameterReflection->isDefaultValueAvailable()) {

                $value = $parameterReflection->getDefaultValue();

            } else {

                $value = null;

            }

            $parameters[$parameterReflection->getName()] = $value;

        }

        return $parameters;

    }

    private function globRecursive($pattern, $flags = 0){

        $namespace = $this->patternToPhpNamespace($pattern);
        $files[$namespace] = $this->pathsToClasses(glob($pattern, $flags));

        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir)
        {
            $dir_name = basename($dir);
            if (!in_array($dir_name, $this->skippedDeirectories)) { // исключаем служебные папки 
                $files = array_merge($files, $this->globRecursive($dir.'/'.basename($pattern), $flags));
            }
        }

        return $files;
    }

    private function patternToPhpNamespace($pattern) {

        $namespace = dirname($pattern);
        $namespace = substr($namespace, strlen($this->rootDirectory) + 1);
        $namespace = str_replace(array('/', '\\'), '_', $namespace);

        return $namespace;

    }

    private function pathsToClasses(array $paths) {

        $classNames = array();
        foreach ($paths as $path) {
            $classNames[] = basename($path, '.php');
        }

        return $classNames;
    }

    private function namespacePhpToJavascript($phpNamespace) {

        $javascriptNamespace = str_replace('_', '.', $phpNamespace);
        $javascriptNamespace = substr( $javascriptNamespace, strlen(implode('_', $this->phpRootNamespaceParts))+1 );
        $javascriptNamespace = strtolower($javascriptNamespace);
        $javascriptNamespace = 'Ext.' . $javascriptNamespace;

        return $javascriptNamespace;

    }

    private function namespaceToUrl($psNamespace) {
        
        $serverFolder = substr($this->rootDirectory, strlen(dirname($this->rootDirectory)) + 1);

        $lsUrl = '/'.$this->siteRootOffset.$serverFolder.'/'.str_replace('_', '/', $psNamespace).'/main.php';
      
        return $lsUrl;
        
    }
    
    private function buildJavascript($namespaces) {

        $api = '';

        foreach ($namespaces as $phpNamespace => $actions) {
            
            $url = $this->namespaceToUrl($phpNamespace);

            $javascriptNamespace = $this->namespacePhpToJavascript($phpNamespace);

            $api .= $this->buildJavascriptNamespace($url, $javascriptNamespace, $actions);

        }

        return $api;

    }
    
    private function buildJavascriptNamespace($url, $javascriptNamespace, $actions) {

        $api = 'Ext.ns("'.$javascriptNamespace.'");'."\n";
        $api .= ''.$javascriptNamespace.'.REMOTING_API = {'."\n";
        $api .= "\t".'"url": "'.str_replace('/', '\/', $url).'",'."\n";
        $api .= "\t".'"namespace": "'.$javascriptNamespace.'",'."\n";
        $api .= "\t".'"type": "remoting",'."\n";
        $api .= "\t".'"actions": {'."\n";

        foreach ($actions as $className => $methods) {

            $api .= "\t\t".'"'.$className.'": ['."\n";

            foreach ($methods as $methodName => $methodDescription) {
                $api .= "\t\t\t".'{'."\n";
                $api .= "\t\t\t\t".'"name": "'.$methodName.'",'."\n";
                $api .= "\t\t\t\t".'"len": '.$methodDescription['length'].','."\n";
                $api .= "\t\t\t\t".'"formHandler": '.($this->methodIsFormHandler($methodName, $methodDescription) ? 'true' : 'false')."\n";
                $api .= "\t\t\t".'},'."\n";
            }

            if (substr($api, strlen($api)-2, 1) == ',') { // убираем лишнюю запятую
                $api = substr($api, 0, strlen($api)-2)."\n";
            }

            $api .= "\t\t".'],'."\n";
        }

        if (substr($api, strlen($api)-2, 1) == ',') { // убираем лишнюю запятую
            $api = substr($api, 0, strlen($api)-2)."\n";
        }

        $api .= "\t".'}'."\n";

        $api .= '};'."\n";


        return $api;

     }

     private function methodIsFormHandler($methodName, array $methodDescription) {

         if (array_key_exists($this->formHandlerParameterName, $methodDescription['parameters'])) {
             return true;
         }

         if (strpos($methodName, ucfirst($this->formHandlerParameterName)) !== false) {
             return true;
         }

         return false;

     }

    private function buildPhp($actions) {

        $api = '<?php return '.var_export($actions, true).';';

        return $api;

    }

}
