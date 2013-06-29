<?php
/**
 * Фабрика кэша
 */
class Doctor_Service_Cache_Factory {
    
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
     * Создаёт кэш-заглушку
     * @return Doctor_Service_Interface_Cache
     */
    public function makeDummy() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new Doctor_Service_Cache_Dummy();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Создаёт файловый кэш
     * @return Doctor_Service_Interface_Cache
     */
    public function makeFile() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new Doctor_Service_Cache_File();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Создаёт кэш, основанный на PHP-сессиях
     * @return Doctor_Service_Interface_Cache
     */
    public function makeSession() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new CModel_Service_Cache_Session();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
}