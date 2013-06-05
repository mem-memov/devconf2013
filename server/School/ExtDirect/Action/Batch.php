<?php
/**
 * Команда пакетного запроса
 */
class School_ExtDirect_Action_Batch extends School_ExtDirect_Abstract_Action {
    
    public function __construct(
        School_ExtDirect_Request_Batch $request, // отличие здесь
        School_ExtDirect_Factory_Controller $controllerFactory,
        School_ExtDirect_Api $api,
        School_ExtDirect_Factory_Response $responseFactory,
        School_ExtDirect_Input $input
    ) {
        
        parent::__construct(
            $request,
            $controllerFactory,
            $api,
            $responseFactory,
            $input
        );
        
    }
    
    /**
     * Исполняет команду
     * @return School_ExtDirect_Response_Batch
     */
    protected function run() {
       
        $class = $this->classJsToPhp($this->request->getClass());
        $method = $this->request->getMethod();
        $parameters = $this->request->getParameters();
        $this->checkApi($class, $method);

        $controller = $this->controllerFactory->getController($class);
      
        $result = $this->runMethod($class, $method, $parameters);
     
        $response = $this
                        ->responseFactory
                        ->getRpcResponse(
                                $this->request->getTransactionId(), 
                                $this->classPhpToJs($class), 
                                $method, 
                                $result
                         )
        ;
        
        return $response;
        
    }
    
}
