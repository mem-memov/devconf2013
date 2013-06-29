<?php
/**
 * Абстрактный ответ сервера
 */
abstract class Doctor_ExtDirect_Abstract_Response extends Doctor_ExtDirect_Abstract_Transaction {
    
    /**
     * Тип ответа
     * @var string 
     */
    protected $type;
    
    /**
     * Результат
     * @var mixed 
     */
    protected $result;
    
    /**
     * Преобразует данный объект в массив
     * @return array 
     */
    abstract public function toArray();
    
}
