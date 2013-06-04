<?php
class School_Service_SqlDatabase_Exception_QueryFailed
extends School_Service_SqlDatabase_Exception_Basic 
{

    public function __construct($lastQuery, $errorMessage, $code = 0, Exception $previous = null) {

        $message = 'Запрос к базе данных вызвал ошибку: ' . $errorMessage 
                   .'Последний запрос: ' . $lastQuery
        ;
        
        parent::__construct($message, $code, $previous);
        
    }
    
}