<?php
class Doctor_DataAccess_Html extends Doctor_DataAccess_Abstract_Provider {
    
    public function create($studentId, $subjectId, $teacherId, $gradeId, $date) {
        
        return $this->db->fetchLastId('
            INSERT INTO assessment (
                student_id, 
                subject_id, 
                teacher_id, 
                grade_id, 
                date
            )
            VALUES (
                '.(int)$studentId.',
                '.(int)$subjectId.',
                '.(int)$teacherId.',
                '.(int)$gradeId.',
                '.$this->db->prepareString($date).'
            );
        ');
        
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
    
    public function destroy($assessmentId) {
        
        return $this->db->fetchNumberOfAffectedRows('
            DELETE FROM
                assessment
            WHERE
                id = '.(int)$assessmentId.'
            ;
        ');
        
    }
    
}