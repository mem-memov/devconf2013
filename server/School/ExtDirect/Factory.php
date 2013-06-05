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
     * @return CFrontend_Input
     */
    public function getInput() {

        $instance_key = __FUNCTION__;

        if (!isset($this->_aInstances[$instance_key])) {
            $this->_aInstances[$instance_key] = new CFrontend_Input();
        }

        return $this->_aInstances[$instance_key];

    }


}