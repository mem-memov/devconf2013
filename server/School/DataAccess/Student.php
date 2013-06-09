<?php
/**
 * Объект доступа к данным профессоров
 */
class School_DataAccess_Student extends School_DataAccess_Abstract_Provider {
    
    public function readNameList() {
        
        return $this->db->fetchRows('
            SELECT 
                person.id,
                person.first_name,
                person.last_name,
                person.image,
                student.year,
                house.house
            FROM
                person
                LEFT JOIN student ON (student.person_id = person.id)
                LEFT JOIN house ON (house.id = student.house_id)
            WHERE
                student.person_id IS NOT NULL
                AND person.image IS NOT NULL
            ;
        ');
        
    }
    
}