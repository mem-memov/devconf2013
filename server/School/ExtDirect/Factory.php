<?php
/**
 * Фабрика объектов, необходимых для работы обработчика клиентских запросов
 */
class School_ExtDirect_Factory {

    /**
     * Единственный экземпляр данного класса в системе
     * @var School_ExtDirect_Factory
     */
    private static $instance;
    
    /** 
     * Настройки системы
     * @var array  
     */
    private $config;
    
    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    protected $instances;

    /**
     * Создаёт экземпляр класса
     * @param array $config настройки системы
     */
    protected function __construct(array $config) {

        $this->config = $config;
        $this->instances = array();
        
        $this->makeClassLoader( dirname(dirname(__DIR__)) )->start();
        
    }
    
    /**
     * Возвращает уникальный экземпляр
     * @param array $config настройки системы
     * @return School_ExtDirect_Factory
     * @throws School_ExtDirect_Exception
     */
    public static function construct(array $config) {

        if (empty(self::$instance)) {

            self::$instance = new self($config);
            return self::$instance;

        } else {

            throw new School_ExtDirect_Exception('Фабрику верхнего уровня можно создавать только один раз.');

        }

    }
    
    /**
     * Создаёт автозагрузчик классов
     * @param type $pathToRootDirectory путь к корневой директории
     * @return School_ExtDirect_ClassLoader
     */
    private function makeClassLoader($pathToRootDirectory) {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            require_once('ClassLoader.php');
            $this->instances[$instanceKey] = new School_ExtDirect_ClassLoader($pathToRootDirectory);
            
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Создаёт обработчик запросов ExtDirect
     * @return School_ExtDirect_Processor
     */
    public function makeProcessor() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_ExtDirect_Processor($this);
            
        }

        return $this->instances[$instanceKey];
        
    }

    /**
     * Создаёт контейнер входных данных
     * 
     * @return School_ExtDirect_Input
     */
    public function makeInput() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            $this->instances[$instanceKey] = new School_ExtDirect_Input();
        }

        return $this->instances[$instanceKey];

    }
    
    /**
     * Создаёт API сервера
     * @return School_ExtDirect_Api
     */
    public function makeApi() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            $api = require_once dirname(dirname(__DIR__)).'/api/api.php';
            $this->instances[$instanceKey] = new School_ExtDirect_Api($api);
        }

        return $this->instances[$instanceKey];

    }
    
    /**
     * Создаёт фабрику запросов
     * @return School_ExtDirect_Factory_Request
     */
    public function makeRequestFactory() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            $this->instances[$instanceKey] = new School_ExtDirect_Factory_Request($this);
        }

        return $this->instances[$instanceKey];

    }

    /**
     * Создаёт фабрику ответов
     * @return School_ExtDirect_Factory_Response
     */
    public function makeResponseFactory() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            $this->instances[$instanceKey] = new School_ExtDirect_Factory_Response($this);
        }

        return $this->instances[$instanceKey];

    }

    /**
     * Создаёт фабрику команд
     * @return School_ExtDirect_Factory_Action
     */
    public function makeActionFactory() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            $this->instances[$instanceKey] = new School_ExtDirect_Factory_Action($this);
        }

        return $this->instances[$instanceKey];

    }
    
    /**
     * Создаёт фабрику контроллеров
     * @return School_ExtDirect_Factory_Controller
     */
    public function makeControllerFactory() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_ExtDirect_Factory_Controller(
                  $this->makeDataAccessFactory(),
                  $this->makeServiceLocator()  
            );
            
        }

        return $this->instances[$instanceKey];

    }

    /**
     * Создаёт фабрику объектов доступа к данных
     * @return School_DataAccess_Factory
     */
    public function makeDataAccessFactory() {

        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_DataAccess_Factory(
                $this->makeServiceLocator()->getDatabase()
            );
            
        }

        return $this->instances[$instanceKey];

    }
    
    /**
     * Cоздаёт поставщика сервисов
     * @return School_Service_Locator
     */
    public function makeServiceLocator() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_Service_Locator(
                $this->config,
                $this->makeServiceFactory()
             );
            
        }

        return $this->instances[$instanceKey];
        
    }


    /**
     * Cоздаёт фабрику сервисов
     * @return School_Service_Factory
     */
    private function makeServiceFactory() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_Service_Factory();
            
        }

        return $this->instances[$instanceKey];
        
    }

}