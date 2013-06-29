<?php
/**
 * Команда веб-формы
 */
class Doctor_ExtDirect_Action_Form extends Doctor_ExtDirect_Abstract_Action {


    public function __construct(
        Doctor_ExtDirect_Request_Form $request, // отличие здесь
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
     * @return Doctor_ExtDirect_Response_Form
     */
    protected function run() {
        
        $class = $this->classJsToPhp($this->request->getClass());
        $method = $this->request->getMethod();
        $parameters = $this->request->getParameters();

        $this->checkApi($class, $method);

        $values = array();
        
        $files = $this->request->getFiles();
        
        // отсекаем служебные значения из тех, что пришли в POST-запросе
        
        $methodParameters = $this->api->getMethodParameters($class, $method);

        foreach($methodParameters as $parameterName => $defaultValue) {

            if (isset($parameters[$parameterName])) {
                $value = $parameters[$parameterName];
            } elseif ($this->request->isUpload() && isset($files[$parameterName])) {
                $value = $files[$parameterName];
            } else {
                $value = $defaultValue;
            }

            $values[] = $value;
        }
        
        // выполняем метод-обработчик формы
        $result = $this->runMethod($class, $method, $values);
        
        if (isset($result['success'], $result['data'])) {
            
            $response = $this
                            ->responseFactory
                            ->getRpcResponse(
                                    $this->request->getTransactionId(), 
                                    $this->classPhpToJs($class), 
                                    $method, 
                                    $result
                             )
            ; 
        
        } else {
            
            $response = $this
                ->responseFactory
                ->getExceptionResponse(
                        $this->request->getTransactionId(), 
                        'Обработчики форм должны возвращать массив [success:true|false, data:[]]', 
                        $class.'::'.$method
                 )
            ;
            
        }
        
        return $response;
        
    }
    
}
