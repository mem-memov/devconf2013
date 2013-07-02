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
    
    public function findNodeById($id) {
        
        if (
                array_key_exists('id', $this->row) // у корневого элемента отсутствует поле id, т.к. он имеет вспомогательное значение и не хранится в базе данных
                && $id == $this->row['id']
        ) {

            return $this;
            
        }
        
        if (is_array($this->children)) {
            
            foreach ($this->children as $child) {

                $foundNode = $child->findNodeById($id);

                if ($foundNode instanceof self) {

                    return $foundNode;

                }

            }
            
        }
        
        return null;
        
    }
    
    public function removeNode(Doctor_Service_TreeMaker_Tree $node) {

        
        $removedNode = null;
        
        if (is_array($this->children)) {
            
            foreach ($this->children as $index => $child) {

                if ($removedNode === $child) {

                    unset($this->children[$index]);
                    return true;

                }

            }
            
            foreach ($this->children as $index => $child) {
                
                $done = $child->removeNode($node);
                
                if ($done) {
                    return true;
                }
                
            }
            
        }

        return false;
        
    }
    
    public function append(Doctor_Service_TreeMaker_Tree  &$targetNode, array &$nodes) {
        
        if ($targetNode === $this) {
            
            foreach ($nodes as $node) {
                
                $this->checkType($node);
                
                $this->children[] = $node;

            }
            
            return true;
            
        } 
        
        if (is_array($this->children)) {
            
            foreach ($this->children as $child) {
                
                $done = $child->append($targetNode, $nodes);
                
                if ($done) {
                    return true;
                }
                
            }
            
        }
        
        return false;
        
        
    }
    
    public function insertBefore(Doctor_Service_TreeMaker_Tree  &$targetNode, array &$nodes) {

        if (is_array($this->children)) {
            
            foreach ($this->children as $index => $child) {

                if ($targetNode === $child) {
                    
                    foreach ($nodes as $node) {
                        $this->checkType($node);
                    }
                    
                    array_splice($this->children, $index, 0, $nodes);
                    
                    return true;
                    
                } else {
                    
                    $done = $child->insertBefore($targetNode, $nodes);
                    
                    if ($done) {
                        return true;
                    }
                    
                }
                
            }
            
        }
        
        return false;
        
    }
    
    public function insertAfter(Doctor_Service_TreeMaker_Tree  &$targetNode, array &$nodes) {

        if (is_array($this->children)) {
            
            foreach ($this->children as $index => $child) {

                if ($targetNode === $child) {
                    
                    foreach ($nodes as $node) {
                        $this->checkType($node);
                    }
                    
                    array_splice($this->children, $index+1, 0, $nodes);
                    
                    return true;
                    
                } else {
                    
                    $done = $child->insertAfter($targetNode, $nodes);
                    
                    if ($done) {
                        return true;
                    }
                    
                }
                
            }
            
        }
        
        return false;
        
    }
    
    private function checkType(Doctor_Service_TreeMaker_Tree $node) {}
    
    
    
    
}
