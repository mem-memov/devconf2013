<?php
class School_Service_SqlDatabase_MsSqlServer_MssqlDriver 
implements
    School_Service_SqlDatabase_MsSqlServer_DriverInterface
{
    
    private $server;
    private $user;
    private $password;
    private $database;
    private $encoding;
    
    private $connection;
    
    public function __construct($server, $user, $password, $database, $encoding) {

        $phpExtensionName = 'mssql';
        if (!extension_loaded($phpExtensionName)) {
            throw new School_Service_SqlDatabase_Exception_PhpExtensionMisssing($phpExtensionName);
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
    
    // School_Service_SqlDatabase_MsSqlServer_DriverInterface: START -----------

    public function fetchNothing($query) {
        
        $this->query($query);
        
    }
    
    public function fetchRows($query) {
        
        $rows = array();
        
        $result = $this->query($query);

        while ($row = mssql_fetch_assoc($result)) {
            
            $rows[] = $row;
            
        }
        
        mssql_free_result($result);
        
        return $rows;

    }

    public function fetchNumberOfAffectedRows($query) {
        
        $result = $this->query($query);
        
        $numberOfAffectedRows = mssql_rows_affected($this->connection);
        
        mssql_free_result($result);
        
        return $numberOfAffectedRows;
  
    }
    
    public function fetchLastId($query) {
        
        $result = $this->query($query);
        
        //http://stackoverflow.com/questions/7494502/get-last-inserted-id-in-sql-server-2008
        
        $rows = $this->fetchRows('SELECT @@IDENTITY AS last_value;');
        
        $lastId = $rows[0]['last_value'];
        
        mssql_free_result($result);
        
        return $lastId;
        
    }
    
    // School_Service_SqlDatabase_MsSqlServer_DriverInterface: END -----------
    
    /**
     * Выполняет подключение к базе данных
     * @return null
     * @throws School_Service_SqlDatabase_Exception_ConnectionFailed
     */
    private function connect() {

        if (is_resource($this->connection)) {
            return;
        }
	
        // Older FreeTDS installations need the FREETDSCONF Environment variable
        putenv('FREETDSCONF=/etc/freetds/freetds.conf');
        // Current release of FreeTDS uses the FREETDS environment variable. So we set both to be sure
        putenv('FREETDS=/etc/freetds/freetds.conf');
        
        //ini_set('mssql.charset', $this->encoding); 

        $this->connection = mssql_connect($this->server, $this->user, $this->password);

        if ($this->connection === false) {
            throw new School_Service_SqlDatabase_Exception_ConnectionFailed(mssql_get_last_message());
        }

        $databaseSelected = mssql_select_db($this->database, $this->connection);

        if (!$databaseSelected) {
            throw newSchool_Service_SqlDatabase_Exception_ConnectionFailed(mssql_get_last_message());
        }
        
    }
    
    /**
     * Выполняет запрос к базе данных
     * @param string $query
     * @return resource
     * @throws School_Service_SqlDatabase_Exception_QueryFailed
     */
    private function query($query) {
        
        //ini_set('mssql.charset', $this->encoding); 
        
        $this->connect();

        $result = @mssql_query($encodedQuery, $this->connection); 
        
        if ($result === false) {
            
            throw new School_Service_SqlDatabase_Exception_QueryFailed(
                $query, 
                mssql_get_last_message()
            );
            
        }
 
        return $result;
        
    }
    
}