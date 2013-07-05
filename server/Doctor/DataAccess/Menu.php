<?php
class Doctor_DataAccess_Menu extends Doctor_DataAccess_Abstract_Provider {
    
    public function load() {
        
        $rows = $this->db->fetchRows('
            SELECT 
                menu.id             AS id, 
                menu.text           AS text, 
                menu.parent_id      AS parent_id, 
                menu.position      AS position,
                menu.leaf           AS leaf,
                menu.link_id        AS link_id,
                menu.link_type_id   AS link_type_id,
                link.type           AS link_type
            FROM 
                menu
                LEFT JOIN link ON (link.id = menu.link_type_id)
            ORDER BY
                menu.position ASC
            ;
        ');
        
        foreach ($rows as $index => $row) {
            $this->db->castBoolean($rows[$index]['leaf']);
        }

        return $rows;
        
    }
    
    public function create($leaf) {

        return $this->db->fetchDefaultId(
            'menu', 
            'id',
            array(
                'leaf' => $this->db->prepareBoolean($leaf)
            )
        );
        
    }
    
    public function update($id, $parentId, $position, $text, $linkId, $linkTypeId, $leaf) {

        if (empty($parentId)) {
            $parentId = 'NULL';
        }

        $this->db->fetchNumberOfAffectedRows('
            UPDATE
                menu
            SET
                parent_id = '.$this->db->prepareIfNull($parentId).',
                position = '.$position.',
                text = '.$this->db->prepareString($text).',
                link_id = '.$this->db->prepareIfNull($linkId).',
                link_type_id = '.$this->db->prepareIfNull($linkTypeId).',
                leaf = '.$this->db->prepareBoolean($leaf).'
            WHERE
                id = '.$id.'
            ;
        ');

    }
    
    public function delete($id) {

        $this->db->fetchNumberOfAffectedRows('
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

}