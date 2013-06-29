<?php
/**
 * Абстрактное действие
 */
abstract class Doctor_ExtDirect_Abstract_Action {
    
    /**
     * Запрос
     * @var Doctor_ExtDirect_Abstract_Request 
     */
    protected $request;
    
    /**
     * Фабрика контроллеров
     * @var Doctor_ExtDirect_Factory_Controller 
     */
    protected $controllerFactory;
    
    /**
     * API сервера
     * @var Doctor_ExtDirect_Api 
     */
    protected $api;
    
    /**
     * Фабрика ответов сервера
     * @var Doctor_ExtDirect_Factory_Response 
     */
    protected $responseFactory;
    
    /**
     * Хранилище входных данных
     * @var Doctor_ExtDirect_Input 
     */
    protected $input;
    
    /** 
     * Общее название пространства имён для клиента и сервера
     * @var string  
     */
    private static $commonNamespace = 'remote';
    
    /**
     * Создаёт экземпляр класса
     * @param Doctor_ExtDirect_Abstract_Request $request Запрос
     * @param Doctor_ExtDirect_Factory_Controller $controllerFactory Фабрика контроллеров сервера
     * @param Doctor_ExtDirect_Api $api API зервера
     * @param Doctor_ExtDirect_Factory_Response $responseFactory Фабрика ответов сервера
     * @param Doctor_ExtDirect_Input $input Хранилище входных данных
     */
    public function __construct(
        Doctor_ExtDirect_Abstract_Request $request,
        Doctor_ExtDirect_Factory_Controller $controllerFactory,
        Doctor_ExtDirect_Api $api,
        Doctor_ExtDirect_Factory_Response $responseFactory,
        Doctor_ExtDirect_Input $input
    ) {
        
        $this->request = $request;
        $this->controllerFactory = $controllerFactory;
        $this->api = $api;
        $this->responseFactory = $responseFactory;
        $this->input = $input;
        
    }
    
    /**
     * Пытается выполнить команду
     * @return Doctor_ExtDirect_Abstract_Response 
     */
    public function tryToRun() {
        
        try {
            
            $response = $this->run();

        }
        catch ( Exception $exception ) {
          
            $response = $this
                ->responseFactory
                ->getExceptionResponse(
                        $this->request->getTransactionId(), 
                        $exception->getMessage(), 
                        $exception->getTraceAsString()
                 )
            ;
         
        }
        
        return $response;
        
    }
    
    /**
     * Исполняет команду
     */
    abstract protected function run();

    /**
     * Выполняет метод контроллера
     * @param string $class
     * @param string $method
     * @param array $parameters
     * @return Doctor_ExtDirect_Abstract_Response 
     */
    protected function runMethod($class, $method, array $parameters) {
        
        $controller = $this->controllerFactory->makeController($class);

        $result = call_user_func_array(array($controller, $method), $parameters);
        
        return $result;
        
    }
    
    /**
     * Проверяет присутствие класса и метода в API сервера
     * @param type $class
     * @param type $method
     * @throws Doctor_ExtDirect_Exception 
     */
    protected function checkApi($class, $method) {

        // Запрещаем использовать методы, которые не внесены в API
        if (!$this->api->methodExists($class, $method)) {
            throw new Doctor_ExtDirect_Exception('Обращение к несуществующему или закрытому методу '.$class.'::'.$method);
        }
        
    }
    
    /**
     * Преобразует название клиентского класса в название серверного класса
     * @param string $jsClass
     * @return string 
     */
    protected function classJsToPhp($jsClass) {

        $commonNamespace = ucwords(self::$commonNamespace);

        $remotePath = preg_replace(
                '/^(.*)('.$commonNamespace.'(.*))\/main.php(.*)$/', 
                '$2', 
                $this->input->getUri()
        );

        // TODO: вынести Doctor
        $class = 'Doctor_'.str_replace('/', '_', $remotePath).'_'.$jsClass;

        return $class;
        
    }
    
    /**
     * Преобразует название серверного класса в название клиентского класса
     * @param string $phpClass
     * @return string 
     */
    protected function classPhpToJs($phpClass) {
        
        $class = substr($phpClass, strlen('Doctor_') + strlen(self::$commonNamespace)+1);

        return $class;
        
    }
    
}
