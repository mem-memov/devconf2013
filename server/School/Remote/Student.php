<?php
class School_Remote_Student extends School_Remote_Abstract_Controller {
    
    public function readNameList() {

         return $this->dataAccessFactory->makeStudent()->readNameList();
    }
    
}