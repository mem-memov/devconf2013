<?php
class School_Service_SqlDatabase_PostgreSql_Adapter 
implements
    School_Service_SqlDatabase_AdapterInterface
{
    
    private $driver;
    
    private $rowTransformerFactory;
    
    public function __construct(
        School_Service_SqlDatabase_PostgreSql_DriverInterface $driver,
        School_Service_SqlDatabase_RowTransformer_RowTransformerFactory $rowTransformerFactory
    ) {
        
        $this->driver = $driver;
        $this->rowTransformerFactory = $rowTransformerFactory;
        
    }
    
    // School_Service_SqlDatabase_AdapterInterface: START ----------------------

    public function query($query) {
        
        $this->driver->query($query);
        
        return null;
        
    }

    public function insertDefault($tableName, $idColumn, array $values = array()) {
        
        
        
    }

    public function fetchRows($query) {
        
        
        
    }

    public function fetchFirstRow($query) {
        
        
        
    }

    public function fetchColumns($query) {
        
        
        
    }

    public function fetchColumn($query, $fieldName) {
        
        
        
    }

    public function fetchValueFromFirstRow($query, $fieldName) {
        
        
        
    }

    public function fetchLastId() {
        
        
        
    }

    public function fetchNumberOfAffectedRows() {
        
        
        
    }

    public function beginTransaction() {
        
        
        
    }

    public function commit() {
        
        
        
    }

    public function rollback() {
        
        
        
    }
    
    public function prepareString($value) {
        
        
        
    }
    
    public function prepareBoolean($value) {
        
        
        
    }
    
    public function prepareIfNull($value) {
        
        
        
    }
    
    public function castBollean(&$value) {
        
        
        
    }
    
    // School_Service_SqlDatabase_AdapterInterface: STOP ----------------------
    
}