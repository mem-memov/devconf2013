<?php
class School_Service_SqlDatabase_Exception_ConnectionFailed
extends School_Service_SqlDatabase_Exception_Basic 
{

    public function __construct($errorMessage, $code = 0, Exception $previous = null) {

        $message = 'Не удалось подсоединиться к базе данных: ' . $errorMessage;
        
        parent::__construct($message, $code, $previous);
        
    }
    
}