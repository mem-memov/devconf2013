<?php
/**
 * Фабрика объектов, необходимых для работы обработчика клиентских запросов
 */
class School_ExtDirect_Factory {

    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    protected $instances;

    /**
     * Создаёт экземпляр класса
     */
    public function __construct() {

        $this->instances = array();
        
    }
    
    /**
     * Создаёт автозагрузчик классов
     * @param type $pathToRootDirectory путь к корневой директории
     * @return School_ExtDirect_ClassLoader
     */
    public function makeClassLoader($pathToRootDirectory) {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            require_once('ClassLoader.php');
            $this->instances[$instanceKey] = new School_ExtDirect_ClassLoader($pathToRootDirectory);
            
        }

        return $this->instances[$instanceKey];
        
    }

    /**
     * Cоздаёт фабрику сервисов
     * @return School_Service_Factory
     */
    public function makeServiceFactory() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_Service_Factory();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Создаёт контейнер входных данных
     * 
     * @return School_ExtDirect_Input
     */
    public function getInput() {

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

        $instance_key = __FUNCTION__;

        if (!isset($this->_aInstances[$instance_key])) {

            $this->_aInstances[$instance_key] = new School_ExtDirect_Factory_Controller($this);
            
        }

        return $this->_aInstances[$instance_key];

    }


}