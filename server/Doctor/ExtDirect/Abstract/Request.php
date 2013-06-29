<?php
/**
 * Абстрактный запрос
 */
abstract class Doctor_ExtDirect_Abstract_Request extends Doctor_ExtDirect_Abstract_Transaction {
    
    /**
     * Тип запроса
     * @var string 
     */
    protected $type;
    
    /**
     * Имя класса
     * @var string 
     */
    protected $class;
    
    /**
     * Имя метода
     * @var string 
     */
    protected $method;
    
    /**
     * Аргументы
     * @var stdObject 
     */
    protected $parameters;
    
    /**
     * Инициализирует запрос
     */
    abstract public function initialize(array $values);
    
    /**
     * Проверяет правильность запроса
     */
    abstract public function isValid();
    
    public function getClass() {
        
        return $this->class;
        
    }
    
    public function getMethod() {
        
        return $this->method;
        
    }
    
    public function getParameters() {
        
        return $this->parameters;
        
    }
    
}
