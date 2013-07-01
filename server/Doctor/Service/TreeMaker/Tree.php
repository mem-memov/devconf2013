<?php
class Doctor_Service_TreeMaker_Tree {
    
    private $row;

    private $children;
    
    
    public function __construct(array &$rows, $myRow = null) {

        // корневой узел
        
        if (is_null($myRow)) {
            
            $this->row = array('text' => '.');

            foreach ($rows as $index => $row) {
                
                if (is_null($row['parent_id'])) {

                    $this->children[] = new self($rows, $row);
                
                }
                
            }
            
            return;
            
        }

        // прочие узлы
        
        $this->row = $myRow;

        foreach ($rows as $index => $row) {
            
            if ($row['parent_id'] == $myRow['id']) {

                $this->children[] = new self($rows, $row);

            }
            
        }
        
    }
    
    public function toArray() {
        
        $array = $this->row;

        if (!empty($this->children)) {

            $array['children'] = array();
            
            foreach ($this->children as $child) {
                $array['children'][] = $child->toArray();
            }
            
        }

        return $array;
        
    }
    
    
}
