<?php
class Doctor_Service_Factory {
    
    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    private $instances;

    public function __construct() {

        $this->instances = array();

    }
    
    /**
     * Создаёт генератор API
     * @param string $siteRootOffset путь от корневой директории сайта до директории приложения
     * @return Doctor_Service_Interface_ApiGenerator
     */
    public function makeApiGenerator($siteRootOffset = '') {

        return new Doctor_Service_ApiGenerator_ApiGenerator($siteRootOffset);

    }
    
    /**
     * Создаёт фабрику баз данных
     * @return Doctor_Service_SqlDatabase_Factory
     */
    public function makeSqlDatabaseFactory() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new Doctor_Service_SqlDatabase_Factory();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Создаёт фабрику кэша 
     * @return Doctor_Service_Cache_Factory
     */
    public function makeCacheFactory() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new Doctor_Service_Cache_Factory();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
}