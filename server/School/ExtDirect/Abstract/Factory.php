<?php
/**
 * Абстрактная фабрика управляющего слоя
 * 
 * Используется для создания специализированных фабрик слоя, предоставляя им доступ к главной фабрике.
 */
abstract class School_ExtDirect_Abstract_Factory {
    
    /**
     * Главная фабрика управляющего слоя
     * @var School_ExtDirect_Factory
     */
    protected $factory;
    
    /**
     * Создаёт объект класса
     * @param School_ExtDirect_Factory $factory 
     */
    public function __construct(School_ExtDirect_Factory $factory) {
        
        $this->factory = $factory;
        
    }
    
}
