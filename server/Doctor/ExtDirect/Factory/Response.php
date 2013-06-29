<?php
/**
 * Фабрика ответов сервера
 */
class Doctor_ExtDirect_Factory_Response extends Doctor_ExtDirect_Abstract_Factory {
    
    /**
     * Создаёт ответ сервера, который содержит описание ошибки
     * @param integer $transactionId
     * @param string $message
     * @param string $trace
     * @return Doctor_ExtDirect_Response_Exception 
     */
    public function getExceptionResponse ($transactionId, $message, $trace) {
        
        return new Doctor_ExtDirect_Response_Exception($transactionId, $message, $trace);
        
    }
    
    /**
     * Создаёт ответ сервера, который содержит результат выполнения процедуры (RPC)
     * @param integer $transactionId
     * @param string $class
     * @param string $method
     * @param type $result
     * @return Doctor_ExtDirect_Response_Rpc 
     */
    public function getRpcResponse ($transactionId, $class, $method, $result) {
        
        return new Doctor_ExtDirect_Response_Rpc($transactionId, $class, $method, $result);
        
    }
    
}
