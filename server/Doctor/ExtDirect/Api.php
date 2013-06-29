<?php
/**
 * API сервера
 * 
 *  
 */
class Doctor_ExtDirect_Api {
    
    /**
     * Описание классов, методов и аргументов, которые включены в API сервера
     * @var array 
     */
    protected static $api;
    
    /**
     * Создаёт объект класса
     * @param array $api 
     */
    public function __construct(array $api) {
        
        if (is_null(self::$api)) {
            self::$api = $api;
        }
        
    }
    
    /**
     * Проверяет, внесён ли метод класса в описание API сервера
     * @param string $class
     * @param string $method
     * @return boolean 
     */
    public function methodExists($class, $method) {
        
        list($namespace, $className) = $this->splitClassFullyClasifiedName($class);
        
        return isset(self::$api[$namespace][$className][$method]);
        
    }
    
    /**
     * Получить количество аргументов метода
     * @param string $class
     * @param string $method
     * @return integer
     * @throws Doctor_ExtDirect_Exception 
     */
    public function getArgumentListLength($class, $method) {
        
        if (!$this->methodExists($class, $method)) {
            throw new Doctor_ExtDirect_Exception('Метод '.$class.'::'.$method.' не существует или недоступен.');
        }
        
        list($namespace, $className) = $this->splitClassFullyClasifiedName($class);
        
        return self::$api[$namespace][$className][$method]['length'];
        
    }
    
    /**
     * Возвращает список параметров метода
     * @param string $class
     * @param string $method
     * @return array
     * @throws exception 
     */
    public function getMethodParameters($class, $method) {
        
        if (!$this->methodExists($class, $method)) {
            throw new exception('Метод '.$class.'::'.$method.' не существует или недоступен.');
        }
        
        list($namespace, $className) = $this->splitClassFullyClasifiedName($class);
        
        return self::$api[$namespace][$className][$method]['parameters'];
        
    }
    
    /**
     * Разбивает полное название класса на имя пространства имён и имя класса
     * @param string $class
     * @return array 
     */
    private function splitClassFullyClasifiedName($class) {
        
        $laClassParts = explode('_', $class);
        $className = array_pop($laClassParts);
        $namespace = implode('_', $laClassParts);
        
        return array($namespace, $className);
        
    }


    
}
