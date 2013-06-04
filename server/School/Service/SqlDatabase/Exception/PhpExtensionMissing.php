<?php
class School_Service_SqlDatabase_Exception_PhpExtensionMisssing
extends School_Service_SqlDatabase_Exception_Basic 
{

    public function __construct($phpExtensionName, $code = 0, Exception $previous = null) {

        $message = 'Не подключено расширение PHP: ' . $phpExtensionName;
        
        parent::__construct($message, $code, $previous);
        
    }
    
}