<?php
/**
 * Фабрика команд
 */
class School_ExtDirect_Factory_Action extends School_ExtDirect_Abstract_Factory {
    
    /**
     * Создаёт команду для формы
     * @param School_ExtDirect_Request_Form $request
     * @return School_ExtDirect_Action_Form 
     */
    public function getFormAction(School_ExtDirect_Request_Form $request) {
        
        return new School_ExtDirect_Action_Form(
            $request,
            $this->factory->makeControllerFactory(),
            $this->factory->makeApi(),
            $this->factory->makeResponseFactory(),
            $this->factory->makeInput()
        );
        
    }
    
    /**
     * Создаёт команду для пакетного запроса
     * @param School_ExtDirect_Request_Batch $request
     * @return School_ExtDirect_Action_Batch 
     */
    public function getBatchAction(School_ExtDirect_Request_Batch $request) {
        
        return new School_ExtDirect_Action_Batch(
            $request,
            $this->factory->makeControllerFactory(),
            $this->factory->makeApi(),
            $this->factory->makeResponseFactory(),
            $this->factory->makeInput()
        );
        
    }

}
