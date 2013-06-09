<?php
class School_DataAccess_Subject extends School_DataAccess_Abstract_Provider {
    
    public function readAll() {
        
        return $this->db->fetchRows('
            SELECT 
                id,
                subject,
                color
            FROM
                subject
            ;
        ');
        
    }
    
}