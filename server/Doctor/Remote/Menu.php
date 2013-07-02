<?php
class Doctor_Remote_Menu extends Doctor_Remote_Abstract_Controller {
    
    public function appendList($parentId, $text) {

        $userPanel = $this->getDomainFactory()->makeUserPanel();
        $list = $userPanel->createMenuList($text);
        $isSuccessful = $userPanel->appendToMenu($parentId, $list);

        $listTree = $list->getTree();
        
        return array(
            'success' => $isSuccessful,
            'children' => array($listTree)
        );
        
    }
    
    public function appendReference($parentId, $text) {

        $userPanel = $this->getDomainFactory()->makeUserPanel();
        $reference = $userPanel->createMenuReference($text);
        $isSuccessful = $userPanel->appendToMenu($parentId, $reference);

        $referenceTree = $reference->getTree();
        
        return array(
            'success' => $isSuccessful,
            'children' => array($referenceTree)
        );
        
    }
    
    public function readMenu(stdClass $request) {

        $parentNodeId = $request->node; // FYI

        $tree = $this->fetchMenuTree();
        
        $response = $tree->toArray(); 
        
        return $response;  
        
    }
    
    public function updateMenu($id, $text, $linkType, $linkId) {

        $userPanel = $this->getDomainFactory()->makeUserPanel();
        $isSuccessful = $userPanel->updateMenuItem($id, $text, $linkType, $linkId);
        
        return array(
            'success' => $isSuccessful
        );
        
    }
    
    public function destroyMenu($id) {

        $userPanel = $this->getDomainFactory()->makeUserPanel();
        $userPanel->destroyMenuItem($id);
        
        return array(
            'success' => true
        );
        
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

        

        return array(
            'success' => true
        );
        
    }

    
    
    
    
    
 
    private function fetchMenuTree() {
        
        $rows = $this->dataAccessFactory->makeMenu()->load();
        $tree = $this->serviceLocator->getTreeMaker($rows);
        
        return $tree;
        
    }
    
}