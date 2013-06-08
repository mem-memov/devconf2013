<?php
class School_Remote_Assessment extends School_Remote_Abstract_Controller {
    
    public function create(stdClass $request) {

        $date =  date_format(new DateTime(), 'Y-m-d');
        
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