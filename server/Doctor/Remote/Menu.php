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

        $rows = $this->dataAccessFactory->makeMenu()->load();
        $tree = $this->serviceLocator->getTreeMaker($rows);
        
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

        $userPanel = $this->getDomainFactory()->makeUserPanel();
        $isSuccessful = $userPanel->moveMenuItems($targetId, $movedIds, $position);

        return array(
            'success' => $isSuccessful
        );
        
    }

    
    
    
    
    
    
    
    public function create(stdClass $request) {

        if (empty($request->date)) {
            $date = $this->dataAccessFactory->makeTimeMachine()->getCurrentDate();
        } else {
            $date = $request->date;
        }

        $assessmentId = $this->dataAccessFactory->makeAssessment()->create(
                $request->student_id, 
                $request->subject_id, 
                $request->teacher_id, 
                $request->grade_id, 
                $date
        );
        
        return array(
            'success' => true,
            'data' => array(
                'id' => $assessmentId,
                'date' => $date
            )
        );
        
    }
    
    public function read(stdClass $request) {

         return $this->dataAccessFactory->makeAssessment()->read(
                 $request->studentId, 
                 $request->subjectId
         );
    }
    
    public function update(stdClass $request) {
        
        $gradeExists = $this->dataAccessFactory->makeGrade()->gradeIdExists($request->grade_id);
        if (!$gradeExists) {
            return array(
                'success' => false
            );
        }

        $this->dataAccessFactory->makeAssessment()->update(
                $request->grade_id
        );
        
        return array(
            'success' => true
        );
    }
            
    public function destroy(stdClass $request) {
        
        $this->dataAccessFactory->makeAssessment()->destroy($request->id);
        
        return array(
            'success' => true
        );
        
    }
    
}