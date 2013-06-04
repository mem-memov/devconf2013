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
    
    private $connection;
    
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
        
        $this->connection = null;

    }
    
    public function __destruct() {
        
        if (is_resource($this->connection)) {
            
            pg_close($this->connection);
            
        }
        
    }

    // School_Service_SqlDatabase_PostgreSql_DriverInterface: START -----------

    public function fetchNothing($query) {
        
        $this->query($query);
        
    }
    
    public function fetchRows($query) {
        
        $rows = array();
        
        $result = $this->query($query);

        while ($row = pg_fetch_assoc($result)) {
            
            $rows[] = $row;
            
        }
        
        pg_free_result($result);
        
        return $rows;

    }

    public function fetchNumberOfAffectedRows($query) {
        
        $result = $this->query($query);
        
        $numberOfAffectedRows = pg_affected_rows($result);
        
        pg_free_result($result);
        
        return $numberOfAffectedRows;
  
    }
    
    public function fetchLastId($query) {
        
        $result = $this->query($query);
        
        // http://stackoverflow.com/questions/55956/mysql-insert-id-alternative-for-postgresql
        $rows = $this->fetchRows('SELECT LASTVAL() AS last_value;');

        $lastId = $rows[0]['last_value'];
        
        pg_free_result($result);
        
        return $lastId;
        
    }
    
    // School_Service_SqlDatabase_PostgreSql_DriverInterface: END -----------
    
    /**
     * Выполняет подключение к базе данных
     * @return null
     * @throws CModel_Service_Postgresql_Exception
     */
    private function connect() {
        
        if (is_resource($this->connection)) {
            return;
        }
        
        $this->connection = pg_connect('host='.$this->server.' port='.$this->port.' dbname='.$this->database.' user='.$this->user.' password='.$this->password.' connect_timeout=1');
        
        if ($this->connection === false) {
            throw new CModel_Service_Postgresql_Exception ('Не удалось подсоединиться к базе данных: ' . pg_last_error());
        }

        $this->setSchema();

    }
    
    /**
     * Устанавливает схему для всех последующих запросов 
     * так, что её не нужно указывать перед именами таблиц
     */
    private function setSchema() {
        
        if (!is_null($this->shema)) {
            $this->query('SET search_path TO '.$this->shema.',public;');
        }
        
    }
    
    /**
     * Выполняет запрос к базе данных
     * @param string $query
     * @return resource
     * @throws School_Service_SqlDatabase_Exception_QueryFailed
     */
    private function query($query) {
        
        $this->connect();

        $result = @pg_query($this->connection, $query);
        
        if ($result === false) {
            
            throw new School_Service_SqlDatabase_Exception_QueryFailed(
                $query, 
                pg_last_error()
            );
            
        }
 
        return $result;
        
    }
    
}