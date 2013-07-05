<?php
/**
 * Обработчик запросов ExtDirect
 */
class Doctor_ExtDirect_Processor {
    
    /**
     * Фабрика объектов, необходимых для работы обработчика клиентских запросов
     * @var Doctor_ExtDirect_Factory
     */
    private $factory;
    
    /**
     * Создаёт экземпляр класса
     * @param Doctor_ExtDirect_Factory $factory фабрика объектов, необходимых для работы обработчика клиентских запросов
     */
    public function __construct(
        Doctor_ExtDirect_Factory $factory
    ) {

        $this->factory = $factory;

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
        $uri,
        $rawRequestString,
        array $post,
        array $files
    ) {
        
        $database = $this->factory->makeServiceLocator()->getDatabase();
        $database->beginTransaction();

        $input = $this->factory->makeInput();
        $input->initialize($post, $files, $rawRequestString, $uri);

        $requestFactory = $this->factory->makeRequestFactory();
        $actionFactory = $this->factory->makeActionFactory();

        // Обраратываем запросы из форм
        if (!isset($headers, $contents)) {

            $formRequest = $input->fetchFormRequest($requestFactory);

            if ($formRequest->isValid()) {

                $formAction = $actionFactory->getFormAction($formRequest);

                $formResponse = $formAction->tryToRun();

                $formResult = $formResponse->toArray();

                list($headers, $contents) = $this->processFormResult($formResult);

            }

        }

        // Обрабатываем пакетные RPC-запросы
        if (!isset($headers, $contents)) {

            $batchRequests = $input->fetchBatchRequests($requestFactory);

            $batchResults = array();

            foreach ($batchRequests as $batchRequest) {

                if ($batchRequest->isValid()) {

                    $batchAction = $actionFactory->getBatchAction($batchRequest);

                    $batchResponse = $batchAction->tryToRun();

                    $batchResults[] = $batchResponse->toArray();

                }

            }

            if (!empty($batchResults)) {

                list($headers, $contents) = $this->processBatchResults($batchResults);

            }

        }
        
        $database->commit();

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

        //$contents = '<html><body><textarea>' . preg_replace( '/&quot;/', '\\&quot;', $contents ) . '</textarea></body></html>';

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