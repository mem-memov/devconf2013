<?php
/**
 * Фабрика контроллеров
 */
class School_ExtDirect_Factory_Controller {
    
    /**
     * Фабрика объектов доступа к данным
     * @var School_DataAccess_Factory
     */
    private $dataAccessFactory;
    
    /**
     * Поставщик сервисов
     * @var School_Service_Locator
     */
    private $serviceLocator;
    
    /**
     * Создаёт экземпляр класса
     */
    public function __construct(
        School_DataAccess_Factory $dataAccessFactory,
        School_Service_Locator $serviceLocator
    ) {
        
        $this->dataAccessFactory = $dataAccessFactory;
        $this->serviceLocator = $serviceLocator;
        
    }
    
    
    /**
     * Создаёт контроллер
     * @param type $class
     * @return CRemote_Abstract_Base
     */
    public function makeController($class) {
        
        return new $class($this->dataAccessFactory, $this->serviceLocator);
        
    }
    
}
