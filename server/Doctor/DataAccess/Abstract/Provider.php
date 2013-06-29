<?php
class Doctor_DataAccess_Abstract_Provider {
    
    /**
     * База данных
     * @var Doctor_Service_Interface_SqlDatabase
     */
    protected $db;
    
    public function __construct(
        Doctor_Service_Interface_SqlDatabase $db
    ) {
        
        $this->db = $db;
        
    }
    
}