<?php
/**
 * Объект доступа к статистике
 */
class School_DataAccess_Statistics extends School_DataAccess_Abstract_Provider {
    
    public function getStudentActivityData($studentId) {
        
        return $this->db->fetchRows('
            SELECT 
               subject.subject,
               subject.color,
               COUNT(assessment.id) AS activity
            FROM
                assessment
                LEFT JOIN grade ON grade.id = assessment.grade_id
                LEFT JOIN subject ON subject.id = assessment.subject_id
            WHERE
                assessment.student_id = '.(int)$studentId.'
            GROUP BY   
                assessment.subject_id
            ;
        ');
        
    }

    public function getHouseRating() {
        
        return $this->db->fetchRows('
            SELECT 
                house.house,
                COUNT(grade.id) AS rating
            FROM
                assessment
                LEFT JOIN grade ON (grade.id = assessment.grade_id)
                LEFT JOIN student ON (student.id = assessment.student_id)
                Left JOIN house ON (house.id = student.house_id)
            WHERE
                grade.passing = 1
            GROUP BY
                house.id
            ORDER BY
               house.house ASC
            ;
        ');
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}