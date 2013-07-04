<?php
class Doctor_Service_SqlDatabase_MySql_MysqliDriver 
implements
    Doctor_Service_SqlDatabase_MySql_DriverInterface
{
    
    private $server;
    private $port;
    private $user;
    private $password;
    private $database;
    
    private $connection;
    
    /**
     * Создаёт экземпляр класса
     * @param string $server имя сервера
     * @param string $port порт
     * @param string $user имя пользователя
     * @param string $password пароль
     * @param string $database имя базы данных
     * @param string $encoding кодировка
     * @throws Doctor_Service_SqlDatabase_Exception_PhpExtensionMisssing
     */
    public function __construct($server, $port, $user, $password, $database, $encoding) {

        $phpExtensionName = 'mysqli';
        if (!extension_loaded($phpExtensionName)) {
            throw new Doctor_Service_SqlDatabase_Exception_PhpExtensionMisssing($phpExtensionName);
        }
        
        $this->server = $server;
        $this->port = $port;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->encoding = $encoding;
        
        $this->connection = null;

    }
    
    public function __destruct() {
        
        if ($this->connection instanceof mysqli) {
            
            $this->connection->close();
            
        }
        
    }
    
    public function fetchNothing($query) {
        
        $this->query($query);
        
    }
    
    public function fetchRows($query) {
        
        $rows = array();
        
        $result = $this->query($query);
        
        if (!($result instanceof mysqli_result)) {
            throw new Doctor_Service_SqlDatabase_Exception_ResultUnexpected(gettype($result), $query);
        }

        while ($row = $result->fetch_assoc()) {
            
            $rows[] = $row;
            
        }
        
        $result->free();
        
        return $rows;

    }

    public function fetchNumberOfAffectedRows($query) {
        
        $result = $this->query($query);
        
        if ($result !== true) {
            throw new Doctor_Service_SqlDatabase_Exception_ResultUnexpected(gettype($result), $query);
        }
        
        return $this->connection->affected_rows;
  
    }
    
    public function fetchLastId($query) {
        
        $result = $this->query($query);
        
        if ($result !== true) {
            throw new Doctor_Service_SqlDatabase_Exception_ResultUnexpected(gettype($result), $query);
        }
        
        if ($this->connection->insert_id == 0) {
            throw new Doctor_Service_SqlDatabase_Exception_Basic('Поле идентификатора не увличивается автоматически. AUTO_INCREMENT = false');
        }

        return $this->connection->insert_id;
        
    }
    
    public function prepareString($value) {
        
        return '"'. $this->connection->real_escape_string($value) . '"';
        
    }

    /**
     * Выполняет подключение к базе данных
     * @return null
     * @throws CModel_Service_Postgresql_Exception
     */
    private function connect() {
        
        if ($this->connection instanceof mysqli) {
            return;
        }

        $this->connection = new mysqli(
                $this->server,
                $this->user,
                $this->password,
                $this->database,
                $this->port
        );
        
        if ($this->connection->connect_error) {
            throw new Doctor_Service_SqlDatabase_Exception_ConnectionFailed($this->connection->connect_error);
        }
        
        $this->query('SET NAMES utf8;'); // устраняем проблемы с кодировкой

    }
    
    /**
     * Выполняет запрос к базе данных
     * @param string $query
     * @return resource|boolean
     * @throws Doctor_Service_SqlDatabase_Exception_QueryFailed
     */
    private function query($query) {
        
        $this->connect();

        $result = $this->connection->query($query);
        
        if ($result === false) {
            
            throw new Doctor_Service_SqlDatabase_Exception_QueryFailed(
                $query,
                $this->connection->error
            );
            
        }
 
        return $result;
        
    }
    
}