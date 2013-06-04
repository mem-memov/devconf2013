<?php
class School_Service_SqlDatabase_Factory {
    
    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    protected $instances;
    
    /**
     * Создаёт экземпляр класса
     */
    protected function __construct() {

        $this->instances = array();
        
    }
    
    /**
     * Создаёт адаптер PostgreSQL
     * @param string $server имя сервера
     * @param string $port порт
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @param string $shema имя схемы
     * @return School_Service_SqlDatabase_PostgreSql_Adapter
     */
    public function makePostgreSqlAdapter(
        $server, 
        $port, 
        $user, 
        $password, 
        $database, 
        $encoding, 
        $shema = null
    ) {
        
        $driver = $this->makePostgreSqlPgsqlDriver(
            $server, 
            $port, 
            $user, 
            $password, 
            $database, 
            $encoding, 
            $shema
        );
        
        return new School_Service_SqlDatabase_PostgreSql_Adapter(
            $driver,
            $this->makeRowTransformerFactory()
        );
        
    }
    
    /**
     * Содаёт драйвер pgsql для PostgreSQL
     * @param string $server имя сервера
     * @param string $port порт
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @param string $shema имя схемы
     * @return School_Service_SqlDatabase_PostgreSql_PgsqlDriver
     */
    private function makePostgreSqlPgsqlDriver(
        $server, 
        $port, 
        $user, 
        $password, 
        $database, 
        $encoding, 
        $shema = null
    ) {

        return new School_Service_SqlDatabase_PostgreSql_PgsqlDriver(
            $server, 
            $port, 
            $user, 
            $password, 
            $database, 
            $encoding, 
            $shema
        );
        
    }
    
    private function makeRowTransformerFactory() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new School_Service_SqlDatabase_RowTransformer_RowTransformerFactory();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
}