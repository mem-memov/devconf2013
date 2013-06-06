<?php
/**
 * Объект доступа к данным профессоров
 */
class School_DataAccess_Professor extends School_DataAccess_Abstract_Provider {
    
    public function readNameList() {
        
        return $this->db->fetchRows('
            SELECT 
                person.id,
                person.first_name,
                person.last_name
            FROM
                person
                LEFT JOIN teacher ON (teacher.person_id = person.id)
            WHERE
                teacher.person_id IS NOT NULL
            ;
        ');
        
    }
    
}