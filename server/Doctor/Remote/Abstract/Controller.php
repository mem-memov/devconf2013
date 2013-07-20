<?php
class Doctor_Remote_Abstract_Controller {
    
    /**
     * Фабрика объектов доступа к данным
     * @var Doctor_DataAccess_Factory
     */
    protected $dataAccessFactory;
    
    /**
     * Поставщик сервисов
     * @var Doctor_Service_Locator
     */
    protected $serviceLocator;
    
    protected $siteId;
    
    private $authenticated;
    
    /**
     * Создаёт экземпляр класса
     */
    public function __construct(
        Doctor_DataAccess_Factory $dataAccessFactory,
        Doctor_Service_Locator $serviceLocator
    ) {
        
        $this->dataAccessFactory = $dataAccessFactory;
        $this->serviceLocator = $serviceLocator;
       
        $this->siteId = $this->dataAccessFactory->makeSite()->fetchSiteId($_SERVER['SERVER_NAME']);

        $this->authenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'];
        
    }
    
    protected function isAuthenticated() {
        
        return $this->authenticated;
        
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