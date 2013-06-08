<?php
/*
 * Успеваемость
 */
class School_DataAccess_Assessment extends School_DataAccess_Abstract_Provider {
    
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
    
    public function read($studentId, $subjectId) {
        
        return $this->db->fetchRows('
            SELECT 
                assessment.id,
                assessment.date,
                assessment.grade_id,
                grade.grade,
                assessment.subject_id,
                assessment.student_id,
                assessment.teacher_id
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