<?php
/**
 * Фабрика ответов сервера
 */
class School_ExtDirect_Factory_Response extends School_ExtDirect_Abstract_Factory {
    
    /**
     * Создаёт ответ сервера, который содержит описание ошибки
     * @param integer $transactionId
     * @param string $message
     * @param string $trace
     * @return School_ExtDirect_Response_Exception 
     */
    public function getExceptionResponse ($transactionId, $message, $trace) {
        
        return new School_ExtDirect_Response_Exception($transactionId, $message, $trace);
        
    }
    
    /**
     * Создаёт ответ сервера, который содержит результат выполнения процедуры (RPC)
     * @param integer $transactionId
     * @param string $class
     * @param string $method
     * @param type $result
     * @return School_ExtDirect_Response_Rpc 
     */
    public function getRpcResponse ($transactionId, $class, $method, $result) {
        
        return new School_ExtDirect_Response_Rpc($transactionId, $class, $method, $result);
        
    }
    
}
