<?php
class School_Remote_Assessment extends School_Remote_Abstract_Controller {
    
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
    
}