<?php
/**
 * Фабрика контроллеров
 */
class Doctor_ExtDirect_Factory_Controller {
    
    /**
     * Фабрика объектов доступа к данным
     * @var Doctor_DataAccess_Factory
     */
    private $dataAccessFactory;
    
    /**
     * Поставщик сервисов
     * @var Doctor_Service_Locator
     */
    private $serviceLocator;
    
    /**
     * Создаёт экземпляр класса
     */
    public function __construct(
        Doctor_DataAccess_Factory $dataAccessFactory,
        Doctor_Service_Locator $serviceLocator
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
