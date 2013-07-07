<?php
class Doctor_Remote_Menu extends Doctor_Remote_Abstract_Controller {
    
    /**
     * Создаёт новый пункт меню
     * @param stdClass $request
     * @return array
     */
    public function createMenuItem($request) {
        
        // если приходит массив, отказываемся выполнять операцию сразу на нескольких узлах
        if (!($request instanceof stdClass)) {
            return;
        }
        
        // TODO: добавить интерфейс
        $linkId = $this->dataAccessFactory->make($request->link_type)->create($this->siteId);
        $linkTypeId = $this->dataAccessFactory->makeLink()->fetchTypeId($request->link_type);

        $tree = $this->fetchMenuTree();

        $parentNode = $tree->findNodeById($request->parentId); // значение parentId устанавливается автоматически Ext.data.TreeStore

        $childId = $this->dataAccessFactory->makeMenu()->create($request->leaf, $this->siteId); // значение leaf устанавливается автоматически Ext.data.TreeStore

        $rows = array(array(
            'id' => $childId,
            'parent_id' => null,
            'position' => null,
            'text' => $request->text,
            'leaf' => $request->leaf,
            'link_id' => $linkId,
            'link_type_id' => $linkTypeId

        ));
        $childNode = $this->serviceLocator->getTreeMaker($rows)->findNodeById($childId);

        $tree->append($parentNode, array($childNode));

        $this->saveMenuTree($tree);

        return array(
            'success' => true,
            'children' => $childNode->toFlatArray()
        );
        
    }
    
    public function deleteMenuItem($request) {
        
        // если приходит массив, отказываемся выполнять операцию сразу на нескольких узлах
        if (!($request instanceof stdClass)) {
            return;
        }

        $tree = $this->fetchMenuTree();

        $removedNode = $tree->findNodeById($request->id);

        $tree->removeNode($removedNode);

        foreach ($removedNode->toFlatArray() as $row) {

            $this->dataAccessFactory->makeMenu()->delete($row['id'], $this->siteId);
            
            if (!empty($row['link_type']) && !empty($row['link_id'])) {
                // TODO: добавить интерфейс
                $this->dataAccessFactory->make($row['link_type'])->delete($this->siteId, $row['link_id']);
            }

        }

        $this->saveMenuTree($tree);
        
        return array(
            'success' => true
        );
        
    }
    
    public function updateMenuItem($request) {
        
        // если приходит массив, отказываемся выполнять операцию сразу на нескольких узлах
        if (!($request instanceof stdClass)) {
            return;
        }

        $tree = $this->fetchMenuTree();

        $tree->updateNode($this->objectToArray($request));

        $this->saveMenuTree($tree);
        
        return array(
            'success' => true
        );
        
    }
    
    public function readMenu($request) {

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
            
            if ($movedNode instanceof Doctor_Service_Interface_TreeMaker) {
                $movedNodes[] = $movedNode;
            }
            
        }
        
        foreach ($movedNodes as $movedNode) {
            
            $tree->removeNode($movedNode);
            
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
        
        $rows = $this->dataAccessFactory->makeMenu()->load($this->siteId);
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
                $row['leaf'],
                $this->siteId
            );
            
        }
        
    }
    
}