<?php
class School_Remote_Assessment extends School_Remote_Abstract_Controller {
    
    public function read(stdClass $request) {

         return $this->dataAccessFactory->makeAssessment()->read(
                 $request->studentId, 
                 $request->subjectId
         );
    }
    
}