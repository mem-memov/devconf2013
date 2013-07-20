<?php
class Doctor_DataAccess_Site extends Doctor_DataAccess_Abstract_Provider {
    
    public function fetchSiteId($siteName) {
        
        return $this->db->fetchValueFromFirstRow('
            SELECT
                id
            FROM
                site
            WHERE
                site = '.$this->db->prepareString($siteName).'
        ', 'id');
        
    }
    
    public function fetchPassword($id) {
        
        return $this->db->fetchValueFromFirstRow('
            SELECT
                password
            FROM
                site
            WHERE
                id = '.(int)$id.'
        ', 'password');
        
    }
    
    
}