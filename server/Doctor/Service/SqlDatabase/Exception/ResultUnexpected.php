<?php
class Doctor_Service_SqlDatabase_Exception_ResultUnexpected
extends Doctor_Service_SqlDatabase_Exception_Basic 
{

    public function __construct($resultType, $lastQuery, $code = 0, Exception $previous = null) {

        $message = 'Запрос к базе данных вернул неожиданный результат: ' . $message
                   . 'Последний запрос: ' . $lastQuery
        ;
        
        parent::__construct($message, $code, $previous);
        
    }
    
}