<?php
class Doctor_DataAccess_Html extends Doctor_DataAccess_Abstract_Provider {
    
    public function create($siteId) {
        
        return $this->db->fetchDefaultId('html', 'id', array(
            'site_id' => (int)$siteId,
            'html' => $this->db->prepareString('')
        ));
        
    }
    
    public function read($siteId, $id) {
        
        return $this->db->fetchRows('
            SELECT 
                id,
                html
            FROM
                html
            WHERE
                site_id = '.(int)$siteId.'
                AND id = '.(int)$id.'
            ;
        ');
        
    }
    
    public function update($siteId, $row) {
        
        return $this->db->fetchNumberOfAffectedRows('
            UPDATE
                html
            SET
                html = '.$this->db->prepareString($row['html']).'
            WHERE
                site_id = '.(int)$siteId.'
                AND id = '.(int)$row['id'].'
            ;
        ');
        
    }
    
    public function delete($siteId, $id) {
        
        return $this->db->fetchNumberOfAffectedRows('
            DELETE FROM
                html
            WHERE
                site_id = '.(int)$siteId.'
                AND id = '.(int)$id.'
            ;
        ');
        
    }
    
}