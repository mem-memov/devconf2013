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
    
    /**
     * Оценки
     * @return Doctor_DataAccess_Grade
     */
    public function makeGrade() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Grade($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Профессоры
     * @return Doctor_DataAccess_Professor
     */
    public function makeProfessor() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Professor($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Учащиеся
     * @return Doctor_DataAccess_Student
     */
    public function makeStudent() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Student($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
    
    /**
     * Успеваемость
     * @return Doctor_DataAccess_Assessment
     */
    public function makeAssessment() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Assessment($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
        
    /**
     * Машина времени
     * @return Doctor_DataAccess_TimeMachine
     */
    public function makeTimeMachine() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_TimeMachine($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
        
    /**
     * Статистика
     * @return Doctor_DataAccess_Statistics
     */
    public function makeStatistics() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Statistics($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
        
    /**
     * Предмет
     * @return Doctor_DataAccess_Subject
     */
    public function makeSubject() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {
            
            $this->instances[$instanceKey] = new Doctor_DataAccess_Subject($this->db);
        }

        return $this->instances[$instanceKey];
        
    }
        
    
}