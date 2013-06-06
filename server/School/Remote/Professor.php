<?php
class School_Remote_Professor extends School_Remote_Abstract_Controller {
    
    public function readNameList() {

         return $this->dataAccessFactory->makeProfessor()->readNameList();
    }
    
}