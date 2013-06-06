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

    /**
     * Конструктор сервиса
     */
    public function __construct($siteRootOffset = '') {
        
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

        $javascript_api = $this->buildJavascript($actions);
        file_put_contents($this->javascriptApiFile, $javascript_api);

        $php_api =$this->buildPhp($actions);
        file_put_contents($this->phpApiFile, $php_api);
        
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

        $class_reflection = new ReflectionClass($className);

        // Получаем открытые методы класса
        $public_method_reflections = $class_reflection->getMethods(ReflectionMethod::IS_PUBLIC);

        foreach ($public_method_reflections as $public_method_reflection) {

            $method_name = $public_method_reflection->name;

            // исключаем специальные и волшебные методы
            if (strlen($method_name) > 2 && substr($method_name, 0, 2) == '__') {
                continue;
            }

            // исключаем статические методы
            if ($public_method_reflection->isStatic()) {
                continue;
            }

            $methods[$method_name] = array(
                'length' => $public_method_reflection->getNumberOfParameters(),
                'parameters' => $this->getMethodParameters($public_method_reflection)
            );

        }

        return $methods;

    }

    private function getMethodParameters(ReflectionMethod $method_reflection) {

        $parameters = array();

        $parameter_reflections = $method_reflection->getParameters();

        foreach ($parameter_reflections as $parameter_reflection) {

            if ($parameter_reflection->isDefaultValueAvailable()) {

                $value = $parameter_reflection->getDefaultValue();

            } else {

                $value = null;

            }

            $parameters[$parameter_reflection->getName()] = $value;

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

    private function namespacePhpToJavascript($php_namespace) {

        $javascript_namespace = str_replace('_', '.', $php_namespace);
        $javascript_namespace = substr( $javascript_namespace, strlen(implode('_', $this->phpRootNamespaceParts))+1 );
        $javascript_namespace = strtolower($javascript_namespace);
        $javascript_namespace = 'Ext.' . $javascript_namespace;

        return $javascript_namespace;

    }

    private function namespaceToUrl($psNamespace) {
        
        $serverFolder = substr($this->rootDirectory, strlen(dirname($this->rootDirectory)) + 1);

        $lsUrl = '/'.$this->siteRootOffset.$serverFolder.'/'.str_replace('_', '/', $psNamespace).'/main.php';
      
        return $lsUrl;
        
    }
    
    private function buildJavascript($namespaces) {

        $api = '';

        foreach ($namespaces as $php_namespace => $actions) {
            
            $url = $this->namespaceToUrl($php_namespace);

            $javascript_namespace = $this->namespacePhpToJavascript($php_namespace);

            $api .= $this->buildJavascriptNamespace($url, $javascript_namespace, $actions);

        }

        return $api;

    }
    
    private function buildJavascriptNamespace($url, $javascript_namespace, $actions) {

        $api = 'Ext.ns("'.$javascript_namespace.'");'."\n";
        $api .= ''.$javascript_namespace.'.REMOTING_API = {'."\n";
        $api .= "\t".'"url": "'.str_replace('/', '\/', $url).'",'."\n";
        $api .= "\t".'"namespace": "'.$javascript_namespace.'",'."\n";
        $api .= "\t".'"type": "remoting",'."\n";
        $api .= "\t".'"actions": {'."\n";

        foreach ($actions as $className => $methods) {

            $api .= "\t\t".'"'.$className.'": ['."\n";

            foreach ($methods as $method_name => $method_description) {
                $api .= "\t\t\t".'{'."\n";
                $api .= "\t\t\t\t".'"name": "'.$method_name.'",'."\n";
                $api .= "\t\t\t\t".'"len": '.$method_description['length']."\n";
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

    private function buildPhp($actions) {

        $api = '<?php return '.var_export($actions, true).';';

        return $api;

    }

}
