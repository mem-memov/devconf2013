<?php
class School_DataAccess_Grade extends School_DataAccess_Abstract_Provider {
    
    public function readAll() {
        
        return $this->db->fetchRows('
            SELECT 
                id,
                grade,
                passing,
                position
            FROM
                grade
            ;
        ');
        
    }
    
    public function gradeIdExists($gradeId) {
        
        $rows = $this->db->fetchRows('
            SELECT 
                id
            FROM
                grade
            WHERE
                id = '.(int)$gradeId.'
            ;
        ');
        
        return !empty($rows);
        
    }
    
}