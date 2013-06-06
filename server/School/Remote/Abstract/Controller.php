<?php
class School_Remote_Abstract_Controller {
    
    /**
     * Фабрика объектов доступа к данным
     * @var School_DataAccess_Factory
     */
    protected $dataAccessFactory;
    
    /**
     * Поставщик сервисов
     * @var School_Service_Locator
     */
    protected $serviceLocator;
    
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
     * Преобразует стандартный объект в ассоциативный массив
     * @param stdClass $d
     * @return array
     */
    protected function objectToArray($d) {
        
        if (is_object($d)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            //Return array converted to object
            return array_map(array($this, 'objectToArray'), $d);
        }
        else {
            // Return array
            return $d;
        }
            
    }
    
}