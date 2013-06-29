<?php
/**
 * Ответ сервера, содержащий сообщение об ошибке
 */
class Doctor_ExtDirect_Response_Exception extends Doctor_ExtDirect_Abstract_Response {
    
    /**
     * Сообщение об ошибке
     * @var string 
     */
    protected $message;
    
    /**
     * Список вызовов методов
     * @var string 
     */
    protected $trace;
    
    /**
     * Создаёт экземпляр класса
     * @param type $transactionId
     * @param type $message
     * @param type $trace 
     */
    public function __construct(
        $transactionId,
        $message,
        $trace
    ) {
        
        $this->transactionId = $transactionId;
        $this->message = $message;
        $this->trace = $trace;
        
        $this->type = 'exception';
        $this->result = 'Exception';
        
    }
    
    public function toArray() {
        
        return array(
            'type'    => $this->type,
            'tid'     => $this->transactionId,
            'message' => $this->message,
            'where'   => $this->trace,
            'result'  => $this->result
        );
        
    }
    
}
