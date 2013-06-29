<?php
class Doctor_Service_SqlDatabase_MsSqlServer_SqlsrvDriver 
implements
    Doctor_Service_SqlDatabase_MsSqlServer_DriverInterface
{
    
    private $server;
    private $user;
    private $password;
    private $database;
    private $encoding;
    
    private $connection;
    
    public function __construct($server, $user, $password, $database, $encoding) {

        $phpExtensionName = 'sqlsrv';
        if (!extension_loaded($phpExtensionName)) {
            throw new Doctor_Service_SqlDatabase_Exception_PhpExtensionMisssing($phpExtensionName);
        }
        
        $this->server = $server;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->encoding = $encoding;
        
        $this->connection = null;
        
    }
    
    public function __destruct() {
        
        if (is_resource($this->connection)) {
            
            sqlsrv_close($this->connection);
            
        }
        
    }
    
    // Doctor_Service_SqlDatabase_MsSqlServer_DriverInterface: START -----------

    public function fetchNothing($query) {
        
        $this->query($query);
        
    }
    
    public function fetchRows($query) {
        
        $rows = array();
        
        $result = $this->query($query);

        while ($row = (array)sqlsrv_fetch_object($result)) {
            
            $rows[] = $row;
            
        }
        
        sqlsrv_free_stmt($result);
        
        return $rows;

    }

    public function fetchNumberOfAffectedRows($query) {
        
        $result = $this->query($query);
        
        $numberOfAffectedRows = sqlsrv_rows_affected($this->connection);
        
        sqlsrv_free_stmt($result);
        
        return $numberOfAffectedRows;
  
    }
    
    public function fetchLastId($query) {
        
        $result = $this->query($query);
        
        //http://stackoverflow.com/questions/7494502/get-last-inserted-id-in-sql-server-2008
        
        $rows = $this->fetchRows('SELECT @@IDENTITY AS last_value;');
        
        $lastId = $rows[0]['last_value'];
        
        sqlsrv_free_stmt($result);
        
        return $lastId;
        
    }
    
    // Doctor_Service_SqlDatabase_MsSqlServer_DriverInterface: END -----------
    
    /**
     * Выполняет подключение к базе данных
     * @return null
     * @throws Doctor_Service_SqlDatabase_Exception_ConnectionFailed
     */
    private function connect() {

        if (is_resource($this->connection)) {
            return;
        }
	
        $this->connection = sqlsrv_connect($this->server, array(
            'Database' => $this->database,
            'UID' => $this->user,
            'PWD' => $this->password,
            'CharacterSet' => $this->encoding,
			'ConnectionPooling' => 0,
			'MultipleActiveResultSets' => 0
        ));
		
        
        if ($this->connection === false) {
            throw new Doctor_Service_SqlDatabase_Exception_ConnectionFailed(
                    print_r(sqlsrv_errors(), true)
            );
        }

    }
    
    /**
     * Выполняет запрос к базе данных
     * @param string $query
     * @return resource
     * @throws Doctor_Service_SqlDatabase_Exception_QueryFailed
     */
    private function query($query) {
        
        $this->connect();

        $result = @sqlsrv_query($this->connection, $query);
        
        if ($result === false) {
            
            throw new Doctor_Service_SqlDatabase_Exception_QueryFailed(
                $query, 
                print_r(sqlsrv_errors(), true)
            );
            
        }
 
        return $result;
        
    }
    
}