<?php
class Doctor_Service_SqlDatabase_Factory {
    
    /** 
     * Контейнер для уникальных объектов
     * @var array  
     */
    protected $instances;
    
    /**
     * Создаёт экземпляр класса
     */
    public function __construct() {

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
     * @param string $schema имя схемы
     * @return Doctor_Service_Interface_SqlDatabase
     */
    public function makePostgreSqlAdapter(
        $server, 
        $port, 
        $user, 
        $password, 
        $database, 
        $encoding, 
        $schema = null
    ) {
        
        $driver = $this->makePostgreSqlPgsqlDriver(
            $server, 
            $port, 
            $user, 
            $password, 
            $database, 
            $encoding, 
            $schema
        );
        
        return new Doctor_Service_SqlDatabase_PostgreSql_Adapter(
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
     * @param string $schema имя схемы
     * @return Doctor_Service_SqlDatabase_PostgreSql_DriverInterface
     */
    private function makePostgreSqlPgsqlDriver(
        $server, 
        $port, 
        $user, 
        $password, 
        $database, 
        $encoding, 
        $schema = null
    ) {

        return new Doctor_Service_SqlDatabase_PostgreSql_PgsqlDriver(
            $server, 
            $port, 
            $user, 
            $password, 
            $database, 
            $encoding, 
            $schema
        );
        
    }
    
    /**
     * Создаёт адаптер MySQL
     * @param string $server имя сервера
     * @param string $port порт
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @return Doctor_Service_Interface_SqlDatabase
     */
    public function makeMySqlAdapter(
        $server, 
        $port, 
        $user, 
        $password, 
        $database, 
        $encoding
    ) {
        
        $driver = $this->makeMySqlMysqliDriver(
            $server, 
            $port, 
            $user, 
            $password, 
            $database, 
            $encoding
        );
        
        return new Doctor_Service_SqlDatabase_MySql_Adapter(
            $driver,
            $this->makeRowTransformerFactory()
        );
        
    }
    
    /**
     * Содаёт драйвер mysqli для MySQL
     * @param string $server имя сервера
     * @param string $port порт
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @return Doctor_Service_SqlDatabase_MySql_DriverInterface
     */
    private function makeMySqlMysqliDriver(
        $server, 
        $port, 
        $user, 
        $password, 
        $database, 
        $encoding
    ) {

        return new Doctor_Service_SqlDatabase_MySql_MysqliDriver(
            $server, 
            $port, 
            $user, 
            $password, 
            $database, 
            $encoding
        );
        
    }
    
    /**
     * Создаёт адаптер MS SQL Server
     * @param string $server имя сервера
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @return Doctor_Service_Interface_SqlDatabase
     */
    public function makeMsSqlServerAdapter(
        $server,
        $user, 
        $password, 
        $database, 
        $encoding
    ) {
        
        if (extension_loaded('sqlsrv')) {
            
            $driver = $this->makeMsSqlServerSqlsrvDriver(
                $server, 
                $user, 
                $password, 
                $database, 
                $encoding
            );
            
        } elseif (extension_loaded('mssql')) {
            
            $driver = $this->makeMsSqlServerMssqlDriver(
                $server, 
                $user, 
                $password, 
                $database, 
                $encoding
            );
            
        } else {
            
            throw new Doctor_Service_Exception('Не подключено расширения PHP для работы с MS SQL Server');

        }

        return new Doctor_Service_SqlDatabase_MsSqlServer_Adapter(
            $driver,
            $this->makeRowTransformerFactory()
        );
        
    }
    
    /**
     * Содаёт драйвер mssql для MS SQL Server
     * @param string $server имя сервера
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @return Doctor_Service_SqlDatabase_MsSqlServer_DriverInterface
     */
    private function makeMsSqlServerMssqlDriver(
        $server,
        $user, 
        $password, 
        $database, 
        $encoding
    ) {

        return new Doctor_Service_SqlDatabase_MsSqlServer_MssqlDriver(
            $server,
            $user, 
            $password, 
            $database, 
            $encoding
        );
        
    }
    
    /**
     * Содаёт драйвер sqlsrv для MS SQL Server
     * @param string $server имя сервера
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @return Doctor_Service_SqlDatabase_MsSqlServer_DriverInterface
     */
    private function makeMsSqlServerSqlsrvDriver(
        $server,
        $user, 
        $password, 
        $database, 
        $encoding
    ) {

        return new Doctor_Service_SqlDatabase_MsSqlServer_SqlsrvDriver(
            $server,
            $user, 
            $password, 
            $database, 
            $encoding
        );
        
    }
    
    private function makeRowTransformerFactory() {
        
        $instanceKey = __FUNCTION__;

        if (!isset($this->instances[$instanceKey])) {

            $this->instances[$instanceKey] = new Doctor_Service_SqlDatabase_RowTransformer_RowTransformerFactory();
            
        }

        return $this->instances[$instanceKey];
        
    }
    
}