<?php
/**
 * Ответ на удалённый вызов процедуры (RPC)
 * 
 * 
 */
class School_ExtDirect_Response_Rpc extends School_ExtDirect_Abstract_Response {
    
    /**
     * Имя класса
     * 
     * @var string 
     */
    protected $class;
    
    /**
     * Имя метода
     * 
     * @var string 
     */
    protected $method;
    
    /**
     * Создаёт экземпляр класса
     * 
     * @param integer $transactionId
     * @param string $class
     * @param string $method
     * @param mixed $result 
     */
    public function __construct(
        $transactionId,
        $class,
        $method,
        $result
    ) {

        $this->transactionId = $transactionId;
        $this->class = $class;
        $this->method = $method;
        $this->result = $result;
        
        $this->type = 'rpc';
        
    }
    
    /**
     * Преобразует данный объект в массив
     * 
     * @return array 
     */
    public function toArray() {
        
        return array(
            'type'    => $this->type,
            'tid'     => $this->transactionId,
            'action'  => $this->class,
            'method'  => $this->method,
            'result'  => $this->result
        );
        
    }
    
}
