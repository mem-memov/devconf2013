<?php
class School_Remote_TimeMachine extends School_Remote_Abstract_Controller {
    
    public function getCurrentDate() {

         return $this->dataAccessFactory->makeTimeMachine()->getCurrentDate();
    }
    
}