<?php
class School_Remote_Authentication extends School_Remote_Abstract_Controller {
    
    public function loginFormHandler($id = null, $password = null) { // FormHandler - переключатель

         return array(
             'success' => true,
             'data' => array()
         );
    }
    
}