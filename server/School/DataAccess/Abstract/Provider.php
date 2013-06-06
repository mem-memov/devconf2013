<?php
class School_DataAccess_Abstract_Provider {
    
    /**
     * База данных
     * @var School_Service_Interface_SqlDatabase
     */
    protected $db;
    
    public function __construct(
        School_Service_Interface_SqlDatabase $db
    ) {
        
        $this->db = $db;
        
    }
    
}