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
    
    public function read() {
        
        return $this->db->fetchRows('
            SELECT 
                id,
                html
            FROM
                html
            ;
        ');
        
    }
    
    public function update($gradeId) {
        
        return $this->db->fetchNumberOfAffectedRows('
            UPDATE
                assessment
            SET
                grade_id = '.(int)$gradeId.'
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