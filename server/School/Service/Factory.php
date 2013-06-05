<?php
class School_Service_Factory {
    
    /** @var array Контейнер для уникальных объектов */
    private $instances;
    
    public function __construct() {

        $this->instances = array();

    }
    
    /**
     * Создаёт генератор API
     * @param string $siteRootOffset путь от корневой директории сайта до директории приложения
     * @return School_Service_ApiGenerator_ApiGenerator
     */
    public function makeApiGenerator($siteRootOffset = '') {

        return new School_Service_ApiGenerator_ApiGenerator($siteRootOffset);

    }
    
}