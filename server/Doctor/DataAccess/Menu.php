<?php
class Doctor_DataAccess_Menu extends Doctor_DataAccess_Abstract_Provider {
    
    public function load() {
        
        $rows = $this->db->fetchRows('
            SELECT 
                menu.id             AS id, 
                menu.text           AS text, 
                menu.parent_id      AS parent_id, 
                menu.order_num      AS order_num,
                menu.is_leaf        AS is_leaf,
                menu.link_id        AS link_id,
                menu.link_type_id   AS link_type_id,
                link.type           AS link_type
            FROM 
                menu
                LEFT JOIN link ON (link.id = menu.link_type_id)
            ORDER BY
                menu.order_num ASC
            ;
        ');
        
        foreach ($rows as $index => $row) {
            $this->db->castBoolean($rows[$index]['is_leaf']);
        }

        return $rows;
        
    }
    
    public function create($isFolder) {

        $this->db->insertDefault(
                                    'menu', 
                                    'id',
                                    array(
                                        'is_folder' => $this->db->prepareBooleanValue($isFolder)
                                    )
        );
        
        return $this->db->last_id();
        
    }
    
    public function update($id, $name) {

        $this->db->query('
            UPDATE
                menu
            SET
                name = \''.$name.'\'
            WHERE
                menu.id = '.$id.'
            ;
        ');
        
    }
    
    public function updateReference($id, $dashboardId) {
        
        if (is_null($dashboardId)) {
            $dashboardId = 'NULL';
        }
       
        $this->db->query('
            UPDATE
                menu
            SET
                dashboard_id = '.$dashboardId.'
            WHERE
                menu.id = '.$id.'
            ;
        ');
        
    }
    
    /**
     * Перемещает меню по дереву
     * @param integer $id ID меню
     * @param integer $position номер по порядку начинается с первого
     * @param integer $parentId ID родительского меню
     */
    public function updatePosition($id, $position, $parentId) {
        
        if (empty($parentId)) {
            $parentId = 'NULL';
        }
        
        $this->db->query('
            UPDATE
                menu
            SET
                parent_id = '.$parentId.',
                order_num = '.$position.'
            WHERE
                id = '.$id.'
            ;
        ');
        
    }
    
    public function delete($id) {
  
        $this->db->query('
            DELETE FROM
                menu
            WHERE
                id = '.$id.'
            ;
        ');
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function create1($studentId, $subjectId, $teacherId, $gradeId, $date) {
        
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
    
    public function read1($studentId, $subjectId) {
        
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
            ORDER BY
                assessment.date DESC
            ;
        ');
        
    }
    
    public function update1($gradeId) {
        
        return $this->db->fetchNumberOfAffectedRows('
            UPDATE
                assessment
            SET
                grade_id = '.(int)$gradeId.'
            ;
        ');
        
    }
    
    public function destroy1($assessmentId) {
        
        return $this->db->fetchNumberOfAffectedRows('
            DELETE FROM
                assessment
            WHERE
                id = '.(int)$assessmentId.'
            ;
        ');
        
    }
    
}