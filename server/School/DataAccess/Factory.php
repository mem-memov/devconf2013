<?php
/**
 * Фабрика объектов доступа к данных
 */
class School_DataAccess_Factory {
    
    /**
     * База данных
     * @var School_Service_Interface_SqlDatabase
     */
    private $db;
    
    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    protected $instances;
    
    /**
     * Создаёт экземпляр класса
     * @param School_Service_Interface_SqlDatabase $db
     */
    public function __construct(
        School_Service_Interface_SqlDatabase $db
    ) {
        
        $this->db = $db;
        
    }
    
    /**
     * Оценки
     * @return School_DataAccess_Grade
     */
    public function makeGrade() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new School_DataAccess_Grade($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Профессоры
     * @return School_DataAccess_Professor
     */
    public function makeProfessor() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new School_DataAccess_Professor($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
}