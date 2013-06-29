<?php
/**
 * Фабрика команд
 */
class Doctor_ExtDirect_Factory_Action extends Doctor_ExtDirect_Abstract_Factory {
    
    /**
     * Создаёт команду для формы
     * @param Doctor_ExtDirect_Request_Form $request
     * @return Doctor_ExtDirect_Action_Form 
     */
    public function getFormAction(Doctor_ExtDirect_Request_Form $request) {
        
        return new Doctor_ExtDirect_Action_Form(
            $request,
            $this->factory->makeControllerFactory(),
            $this->factory->makeApi(),
            $this->factory->makeResponseFactory(),
            $this->factory->makeInput()
        );
        
    }
    
    /**
     * Создаёт команду для пакетного запроса
     * @param Doctor_ExtDirect_Request_Batch $request
     * @return Doctor_ExtDirect_Action_Batch 
     */
    public function getBatchAction(Doctor_ExtDirect_Request_Batch $request) {
        
        return new Doctor_ExtDirect_Action_Batch(
            $request,
            $this->factory->makeControllerFactory(),
            $this->factory->makeApi(),
            $this->factory->makeResponseFactory(),
            $this->factory->makeInput()
        );
        
    }

}
