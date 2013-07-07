<?php
class Doctor_DataAccess_Link extends Doctor_DataAccess_Abstract_Provider {
    
    public function fetchTypeId($type) {
        
        return $this->db->fetchValueFromFirstRow('
            SELECT
                id
            FROM
                link
            WHERE
                type = '.$this->db->prepareString($type).'
        ', 'id');
        
    }
    
    public function fetchType($id) {
        
        return $this->db->fetchValueFromFirstRow('
            SELECT
                type
            FROM
                link
            WHERE
                id = '.(int)$id.'
        ', 'type');
        
    }
    
    
}