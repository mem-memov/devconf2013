<?php
class School_Service_SqlDatabase_PostgreSql_PgsqlDriver 
implements
    School_Service_SqlDatabase_PostgreSql_DriverInterface
{
    
    private $server;
    private $port;
    private $user;
    private $password;
    private $database;
    private $shema;
    
    /**
     * Создаёт экземпляр класса
     * @param string $server имя сервера
     * @param string $port порт
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @param string $shema имя схемы
     * @throws School_Service_SqlDatabase_Exception_PhpExtensionMisssing
     */
    public function __construct($server, $port, $user, $password, $database, $encoding, $shema = null) {

        $phpExtensionName = 'pgsql';
        if (!extension_loaded($phpExtensionName)) {
            throw new School_Service_SqlDatabase_Exception_PhpExtensionMisssing($phpExtensionName);
        }
        
        $this->server = $server;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->encoding = $encoding;
        $this->shema = $shema;

    }
    public function __destruct() {
        if (is_resource($this->connection)) {
            pg_close($this->connection);
        }
    }
    
    
}