<?php
class Doctor_Remote_Menu extends Doctor_Remote_Abstract_Controller {
    
    /**
     * Создаёт новый пункт меню
     * @param stdClass|array $requests
     * @return array
     */
    public function createMenuItem($requests) {
        
        if ($requests instanceof stdClass) {
            $requests = array($requests);
        }
        
        $tree = $this->fetchMenuTree();

        foreach ($requests as $request) {
            
            $parentNode = $tree->findNodeById($request->parentId); // значение parentId устанавливается автоматически Ext.data.TreeStore
            
            $childId = $this->dataAccessFactory->makeMenu()->create($request->leaf); // значение leaf устанавливается автоматически Ext.data.TreeStore

            $rows = array(array(
                'id' => $childId,
                'parent_id' => null,
                'position' => null,
                'text' => $request->text,
                'leaf' => $request->leaf,
                'link_id' => null,
                'link_type_id' => null

            ));
            $childNode = $this->serviceLocator->getTreeMaker($rows)->findNodeById($childId);

            $tree->append($parentNode, array($childNode));
            
        }

        $this->saveMenuTree($tree);

        return array(
            'success' => true,
            'children' => $childNode->toFlatArray()
        );
        
    }
    
    public function deleteMenuItem($requests) {
        
        if ($requests instanceof stdClass) {
            $requests = array($requests);
        }
        
        $tree = $this->fetchMenuTree();

        foreach ($requests as $request) {
            
            $removedNode = $tree->findNodeById($request->id);
            
            $tree->removeNode($removedNode);

            foreach ($removedNode->toFlatArray() as $row) {

                $this->dataAccessFactory->makeMenu()->delete($row['id']);
                
            }

        }
        
        $this->saveMenuTree($tree);
        
        return array(
            'success' => true
        );
        
    }
    
    public function updateMenuItem($requests) {
        
        if ($requests instanceof stdClass) {
            $requests = array($requests);
        }
        
        $tree = $this->fetchMenuTree();

        foreach ($requests as $request) {
            
            $tree->updateNode($this->objectToArray($request));

        }

        $this->saveMenuTree($tree);
        
        return array(
            'success' => true
        );
        
    }
    
    public function readMenu(stdClass $request) {

        $parentNodeId = $request->node;
        
        if ($parentNodeId == 0) {
            $parentNodeId = null;
        }

        $tree = $this->fetchMenuTree();

        $node = $tree->findNodeById($parentNodeId);
        
        $response = $node->toArray(); 
        
        return $response;  
        
    }
    
    /**
     * Перемещает пункты меню
     * @param integer $targetId
     * @param integer[] $movedIds
     * @param string $position "before", "after" или "append"
     */
    public function updatePositions($targetId, array $movedIds, $position) {

        $tree = $this->fetchMenuTree();
        
        $targetNode = $tree->findNodeById($targetId);
        
        $movedNodes = array();
        
        foreach ($movedIds as $movedId) {
            
            $movedNode = $tree->findNodeById($movedId);
            
            if ($movedNode instanceof Doctor_Service_TreeMaker_Tree) {
                $movedNodes[] = $movedNode;
            }
            
        }

        switch ($position) {
            case 'before':
                $tree->insertBefore($targetNode, $movedNodes);
                break;
            case 'after':
                $tree->insertAfter($targetNode, $movedNodes);
                break;
            case 'append':
                $tree->append($targetNode, $movedNodes);
                break;
            default:
                throw new Exception('Неизвестное расположение: ' . $position);
                break;
        }

        $this->saveMenuTree($tree);

        return array(
            'success' => true
        );
        
    }

    
    
    
    
    
    /**
     * 
     * @return Doctor_Service_Interface_TreeMaker
     */
    private function fetchMenuTree() {
        
        $rows = $this->dataAccessFactory->makeMenu()->load();
        $tree = $this->serviceLocator->getTreeMaker($rows);
        
        return $tree;
        
    }
    
    private function saveMenuTree(Doctor_Service_Interface_TreeMaker $tree) {
        
        foreach ($tree->toFlatArray() as $row) {

            $this->dataAccessFactory->makeMenu()->update(
                $row['id'], 
                $row['parent_id'], 
                $row['position'], 
                $row['text'], 
                $row['link_id'], 
                $row['link_type_id'], 
                $row['leaf']
            );
            
        }
        
    }
    
}