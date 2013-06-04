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
     * Обрабатывает запрос браузера
     * @param string $requestUri
     * @param string $rawPostString
     * @param array $files
     * @return array
     */
    public function process(
        $requestUri,
        $rawPostString,
        array $files
    ) {
        
        return array(array(), '');
        
    }
    
}