<?php
class School_Remote_Grade extends School_Remote_Abstract_Controller {
    
    public function readAll() {

         return array(
             'success' => true,
             'data' => $this->dataAccessFactory->makeGrade()->readAll()
         );
    }
    
}