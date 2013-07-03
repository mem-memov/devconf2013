<?php
class Doctor_Service_TreeMaker_Tree {
    
    private $row;

    private $children;
    
    
    public function __construct(array &$rows, $myRow = null) {

        // корневой узел
        
        if (is_null($myRow)) {
            
            $this->row = array('id' => null, 'text' => '.', 'leaf' => false, 'loaded' => true);

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
        
        if ($this->row['leaf']) {
            $array['loaded'] = true;
        }

        if (is_array($this->children) && !empty($this->children)) {

            $array['children'] = array();
            
            foreach ($this->children as $child) {
                $array['children'][] = $child->toArray();
            }
            
        }

        return $array;
        
    }
    
    public function toFlatArray() {
        
        $flatArray = $this->isRootNode() ? array() : array($this->row);
        
        if (is_array($this->children)) {

            foreach ($this->children as $child) {
                
                $flatArray = array_merge($flatArray, $child->toFlatArray());
                
            }

        }

        return $flatArray;
        
    }
    
    public function findNodeById($id = null) {
        
        if (empty($id) && $this->isRootNode()) {
            return $this;
        }
        
        if (!$this->isRootNode() && $id == $this->row['id']) {

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
        
        if ($this->isRootNode()) {
            
            throw new Exception('Невозможно удалить корневой узел');
            
        }

        if ($node === $this) { // находимся в удаляемом узле
            
            $this->row['parent_id'] = -1;
            return true;
            
        }

        if (is_array($this->children)) {

            foreach ($this->children as $index => $child) {
                
                $done = $child->removeNode($node);
                
                if ($done) {
                    
                    if ($node === $child) { // находимся в родительском узле удаляемого узла
                        unset($this->children[$index]);
                    }
                    
                    return true;
                }
                
            }
            
        }

        return false;
        
    }
    
    public function append(Doctor_Service_TreeMaker_Tree  $targetNode, array $nodes) {
        
        if ($targetNode === $this) {

            foreach ($nodes as $node) {
                
                $this->checkType($node);
                
                $this->children[] = $node;

            }

            $this->orderChildren();

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
    
    public function insertBefore(Doctor_Service_TreeMaker_Tree  $targetNode, array $nodes) {

        if (is_array($this->children)) {
            
            foreach ($this->children as $index => $child) {

                if ($targetNode === $child) {
                    
                    foreach ($nodes as $node) {
                        $this->checkType($node);
                    }
                    
                    array_splice($this->children, $index, 0, $nodes);
                    
                    $this->orderChildren();
                    
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
    
    public function insertAfter(Doctor_Service_TreeMaker_Tree  $targetNode, array $nodes) {

        if (is_array($this->children)) {
            
            foreach ($this->children as $index => $child) {

                if ($targetNode === $child) {
                    
                    foreach ($nodes as $node) {
                        $this->checkType($node);
                    }
                    
                    array_splice($this->children, $index+1, 0, $nodes);
                    
                    $this->orderChildren();
                    
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
    
    private function joinParent($parentId, $orderNumber) {
        
        $this->row['parent_id'] = $parentId;
        $this->row['position'] = $orderNumber;
        
    }
    
    private function checkType(Doctor_Service_TreeMaker_Tree $node) {}
    
    private function isRootNode() {
        
        return is_null($this->row['id']); // корневой узел имеет вспомогательное значение и не хранится в базе данных
        
    }
    
    private function orderChildren() {
        
        if (is_array($this->children)) {
            
            foreach ($this->children as $index => $child) {
                $child->joinParent($this->row['id'], $index+1);
            }
            
        }
        
    }
    
    
}
