<?php
class Doctor_Remote_Authentication extends Doctor_Remote_Abstract_Controller {
    
    public function loginFormHandler($password = null) { // FormHandler - переключатель

        $correctPassword = $this->dataAccessFactory->makeSite()->fetchPassword($this->siteId);
        
        return array(
            'success' => ($correctPassword == $password),
            'data' => array()
        );
    }
    
}