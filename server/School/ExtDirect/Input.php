<?php
/**
 * Контейнер входных данных
 */
class School_ExtDirect_Input {
    
    /** 
     * Массив данных из POST-запроса 
     * @var array 
     */
    private $post;
    
    /** 
     * Массив данных с информацией о загруженных файлах
     * @var array 
     */
    private $files;
    
    /** 
     * Необработанные данные из тела запроса php://input
     * @var string 
     */
    private $rawRequestString;
    
    /**
     * URI
     * @var string
     */
    private $uri;
    
    /**
     * Создаёт экземпляр класса 
     */
    public function __construct() {
  
    }
    
    /**
     * Инициализирует запрос
     * @param array $post массив данных из POST-запроса
     * @param array $files
     * @param string $rawRequestString необработанные данные из тела запроса php://input
     * @param string $uri
     */
    public function initialize(
        array $post, 
        array $files, 
        $rawRequestString,
        $uri
    ) {
        
        if (
            !is_null($this->post) 
            || !is_null($this->files) 
            || !is_null($this->rawRequestString)
        ) {
            throw new School_ExtDirect_Exception('Повторная инициализация запроса невозможна.');
        }
        
        $this->post = $post;
        $this->files = $files;
        $this->rawRequestString = $rawRequestString;
        $this->uri = $uri;
        
    }
    
    /**
     * Предоставляет запрос, отправленный из формы 
     * @link http://www.sencha.com/products/extjs/extdirect
     * @param School_ExtDirect_Factory_Request $requestFactory
     * @return School_ExtDirect_Request_Form
     */
    public function fetchFormRequest(School_ExtDirect_Factory_Request $requestFactory) {

        $formRequest = $requestFactory->getFormRequest($this->post, $this->files);
        
        return $formRequest;
        
    }
    
    /**
     * Предоставляет массив RPC-запросов 
     * @link http://www.sencha.com/products/extjs/extdirect
     * @param School_ExtDirect_Factory_Request $rrequestFactory
     * @return array
     */
    public function fetchBatchRequests(School_ExtDirect_Factory_Request $rrequestFactory) {
        
        $laBatchRequests = array();
        
        // получаем стандартные объекты с описанием удалённых вызовов процедур (RPC)
        $rpcs = json_decode($this->rawRequestString);

        if (!is_null($rpcs)) {
        
            // обеспечиваем формат данных - массив объектов
            if (!is_array($rpcs)) {
                $rpcs = array($rpcs);
            }

            // создаём запросы
            foreach ($rpcs as $rpc) {

                $laBatchRequests[] = $rrequestFactory->getBatchRequest(get_object_vars($rpc));

            }
        
        }

        return $laBatchRequests;
        
    }
    
    public function getUri() {
        
        return $this->uri;
        
    }

    
}
