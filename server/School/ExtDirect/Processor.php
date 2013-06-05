<?php
/**
 * Обработчик запросов ExtDirect
 */
class School_ExtDirect_Processor {
    
    /**
     * Единственный экземпляр данного класса в системе
     * @var School_ExtDirect_Processor
     */
    private static $instance;
    
    /** 
     * Настройки системы
     * @var array  
     */
    private $config;
    
    /**
     * Фабрика объектов, необходимых для работы обработчика клиентских запросов
     * @var School_ExtDirect_Factory
     */
    private $factory;
    
    /**
     * Создаёт экземпляр класса
     * @param array $config настройки системы
     * @param School_ExtDirect_Factory $factory фабрика объектов, необходимых для работы обработчика клиентских запросов
     */
    protected function __construct(
        array $config,
        School_ExtDirect_Factory $factory
    ) {

        $this->config = $config;
        $this->factory = $factory;
        
        $this->factory->makeClassLoader( dirname(dirname(__FILE__)) )->start();

    }
    
    /**
     * Возвращает уникальный экземпляр
     * @param array $config настройки системы
     * @param School_ExtDirect_Factory $factory фабрика объектов, необходимых для работы обработчика клиентских запросов
     * @return School_ExtDirect_Processor
     * @throws School_ExtDirect_Exception
     */
    public static function construct(
        array $config,
        School_ExtDirect_Factory $factory
    ) {

        if (empty(self::$instance)) {

            self::$instance = new self($config, $factory);
            return self::$instance;

        } else {

            throw new School_ExtDirect_Exception('Процессор можно создавать только один раз.');

        }

    }
    
    /**
     * Обрабатывает запрос в виде набора массивов и возвращает текст и заголовки для отправки в браузер.
     * @param string $requestUri адрес страницы - для назначения конечного обработчика запроса
     * @param string $rawPostString необработанные данные из тела запроса php://input - RPC
     * @param array $post данные полей HTML-формы
     * @param array $files файлы, переданные из HTML-формы
     * @return array
     */
    public function process(
        $requestUri,
        $rawPostString,
        array $post,
        array $files
    ) {

        $input = $this->factory->getInput();
        $input->initialize($post, $files, $rawRequestString, $uri);

        $requestFactory = $this->factory->getRequestFactory();
        $loActionFactory = $this->factory->getActionFactory();

        // Обраратываем запросы из форм
        if (!isset($headers, $contents)) {

            $formRequest = $input->fetchFormRequest($requestFactory);

            if ($formRequest->isValid()) {

                $formAction = $loActionFactory->getFormAction($formRequest);

                $formResponse = $formAction->tryToRun();

                $laFormResult = $formResponse->toArray();

                list($headers, $contents) = $this->processFormResult($laFormResult);

            }

        }

        // Обрабатываем пакетные RPC-запросы
        if (!isset($headers, $contents)) {

            $batchRequests = $input->fetchBatchRequests($requestFactory);

            $batchResults = array();

            foreach ($batchRequests as $batchRequest) {

                if ($batchRequest->isValid()) {

                    $batchAction = $loActionFactory->getBatchAction($batchRequest);

                    $batchResponse = $batchAction->tryToRun();

                    $batchResults[] = $batchResponse->toArray();

                }

            }

            if (!empty($batchResults)) {

                list($headers, $contents) = $this->processBatchResults($batchResults);

            }

        }

        // Сообщаем, что обработать запрос не можем
        if (!isset($headers, $contents)) {

            $headers = array();
            $contents = '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head><body>Неверный запрос. <a href="api.js">API</a></body>';

        }

        return array($headers, $contents);

    }

    /**
     * Подготавливает ответ для формы
     *
     * @param array $formResult
     * @return array
     */
    private function processFormResult($formResult) {

        $headers = array('Content-Type: text/html');

        $contents = utf8_encode(json_encode($formResult));

        $contents = '<html><body><textarea>' . preg_replace( '/&quot;/', '\\&quot;', $contents ) . '</textarea></body></html>';

        return array($headers, $contents);

    }

    /**
     * Подготавливает ответ для пакетного вызова
     * @param array $batchResults
     * @return array
     */
    private function processBatchResults($batchResults) {

        $headers = array('Content-Type: text/javascript');

        $contents = utf8_encode(json_encode($batchResults));

        return array($headers, $contents);

    }
    
}