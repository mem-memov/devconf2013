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
    
    
}