<?php
/**
 * Команда пакетного запроса
 */
class Doctor_ExtDirect_Action_Batch extends Doctor_ExtDirect_Abstract_Action {
    
    public function __construct(
        Doctor_ExtDirect_Request_Batch $request, // отличие здесь
        Doctor_ExtDirect_Factory_Controller $controllerFactory,
        Doctor_ExtDirect_Api $api,
        Doctor_ExtDirect_Factory_Response $responseFactory,
        Doctor_ExtDirect_Input $input
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
     * @return Doctor_ExtDirect_Response_Batch
     */
    protected function run() {
       
        $class = $this->classJsToPhp($this->request->getClass());
        $method = $this->request->getMethod();
        $parameters = $this->request->getParameters();
        $this->checkApi($class, $method);

        $controller = $this->controllerFactory->makeController($class);
      
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
