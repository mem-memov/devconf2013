<?php
/**
 * Контейнер входных данных
 * 
 *  
 */
class School_ExtDirect_Input {
    
    /** 
     * Массив данных из POST-запроса 
     * 
     * @var array 
     */
    private $_post;
    
    /** 
     * Массив данных с информацией о загруженных файлах
     * 
     * @var array 
     */
    private $_files;
    
    /** 
     * Необработанные данные из тела запроса php://input
     * 
     * @var string 
     */
    private $_rawRequestString;
    
    /**
     * URI
     * 
     * @var string
     */
    private $sUri;
    
    /**
     * Создаёт экземпляр класса 
     */
    public function __construct() {
  
    }
    
    /**
     * Инициализирует запрос
     * 
     * @param array $paPost массив данных из POST-запроса
     * @param array $files
     * @param string $psRawRequestString необработанные данные из тела запроса php://input
     * @param string $psUri
     */
    public function initialize(
        array $paPost, 
        array $files, 
        $psRawRequestString,
        $psUri
    ) {
        
        if (
            !is_null($this->post) 
            || !is_null($this->files) 
            || !is_null($this->rawRequestString)
        ) {
            throw new School_ExtDirect_Exception('Повторная инициализация запроса невозможна.');
        }
        
        $this->post = $paPost;
        $this->files = $files;
        $this->rawRequestString = $psRawRequestString;
        $this->sUri = $psUri;
        
    }
    
    /**
     * Предоставляет запрос, отправленный из формы 
     * 
     * @link http://www.sencha.com/products/extjs/extdirect
     * 
     * @param School_ExtDirect_Factory_Request $rrequestFactory
     * @return School_ExtDirect_Request_Form
     */
    public function fetchFormRequest(School_ExtDirect_Factory_Request $rrequestFactory) {

        $formRequest = $rrequestFactory->getFormRequest($this->post, $this->files);
        
        return $formRequest;
        
    }
    
    /**
     * Предоставляет массив RPC-запросов 
     * 
     * @link http://www.sencha.com/products/extjs/extdirect
     * 
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
        return $this->sUri;
    }

    
}
