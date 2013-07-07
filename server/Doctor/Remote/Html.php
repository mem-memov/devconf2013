<?php
class Doctor_Remote_Html extends Doctor_Remote_Abstract_Controller {
    
    public function read(stdClass $request) {

         return $this->dataAccessFactory->makeHtml()->read($this->siteId, $request->id);
    }
    
    public function update(stdClass $request) {
        
        $affected = $this->dataAccessFactory->makeHtml()->update(
                $this->siteId, 
                $this->objectToArray($request)
        );
        
        return array(
            'success' => !empty($affected)
        );
    }
    
}