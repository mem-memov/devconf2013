<?php
/**
 * Фабрика объектов доступа к данных
 */
class Doctor_DataAccess_Factory {
    
    /**
     * База данных
     * @var Doctor_Service_Interface_SqlDatabase
     */
    private $db;
    
    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    protected $instances;
    
    /**
     * Создаёт экземпляр класса
     * @param Doctor_Service_Interface_SqlDatabase $db
     */
    public function __construct(
        Doctor_Service_Interface_SqlDatabase $db
    ) {
        
        $this->db = $db;
        
    }
    
    public function make($type) {
        
        $method = 'make' . ucfirst($type);
        
        return $this->$method();
        
    }
    
    /**
     * Сайт
     * @return Doctor_DataAccess_Site
     */
    public function makeSite() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Site($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Компонеты
     * @return Doctor_DataAccess_Link
     */
    public function makeLink() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Link($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Меню
     * @return Doctor_DataAccess_Menu
     */
    public function makeMenu() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Menu($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Панель HTML
     * @return Doctor_DataAccess_Html
     */
    public function makeHtml() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Html($this->db);
        }

        return $this->instances[$instanceKey];
        
    }

}