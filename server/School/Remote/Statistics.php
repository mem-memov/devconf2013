<?php
class School_Remote_Statistics extends School_Remote_Abstract_Controller {
    
    public function getHouseRating() {
        
        return $this->dataAccessFactory->makeStatistics()->getHouseRating();
        
    }
    
    public function getStudentActivityData(stdClass $request) {
        
        $subjects = $this->dataAccessFactory->makeSubject()->readAll();
        
        $activityDataSets = $this->dataAccessFactory->makeStatistics()->getStudentActivityData(
                $request->studentId
        );
        
        foreach ($subjects as $subjectIndex => $subject) {
            
            $found = false;
            
            foreach ($activityDataSets as $activityDataSet) {
                
                if ($activityDataSet['subject'] == $subject['subject']) {
                    
                    $subjects[$subjectIndex]['activity'] = $activityDataSet['activity'];
                    $found = true;
                    break;
                    
                }
                
            }
            
            if (!$found) {
                
                $subjects[$subjectIndex]['activity'] = 0;
                
            }

        }

        return $subjects;
        
    }
    
}