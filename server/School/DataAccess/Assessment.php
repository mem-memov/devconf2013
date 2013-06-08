<?php
/*
 * Успеваемость
 */
class School_DataAccess_Assessment extends School_DataAccess_Abstract_Provider {
    
    public function read($studentId, $subjectId) {
        
        return $this->db->fetchRows('
            SELECT 
                assessment.id,
                assessment.date,
                assessment.grade_id,
                grade.grade
            FROM
                assessment
                LEFT JOIN grade ON (grade.id = assessment.grade_id)
            WHERE
                assessment.student_id = '.(int)$studentId.'
                AND assessment.subject_id = '.(int)$subjectId.'
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
    
}