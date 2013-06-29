<?php
/**
 * Абстрактная фабрика управляющего слоя
 * 
 * Используется для создания специализированных фабрик слоя, предоставляя им доступ к главной фабрике.
 */
abstract class Doctor_ExtDirect_Abstract_Factory {
    
    /**
     * Главная фабрика управляющего слоя
     * @var Doctor_ExtDirect_Factory
     */
    protected $factory;
    
    /**
     * Создаёт объект класса
     * @param Doctor_ExtDirect_Factory $factory 
     */
    public function __construct(Doctor_ExtDirect_Factory $factory) {
        
        $this->factory = $factory;
        
    }
    
}
