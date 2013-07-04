<?php
class Doctor_Service_SqlDatabase_MySql_Adapter 
implements
    Doctor_Service_Interface_SqlDatabase
{
    
    /**
     * Драйвер базы данных
     * @var Doctor_Service_SqlDatabase_MySql_DriverInterface 
     */
    private $driver;
    
    /**
     * Фабрика преобразователей табличных данных
     * @var Doctor_Service_SqlDatabase_RowTransformer_RowTransformerFactory
     */
    private $rowTransformerFactory;
    
    /**
     * Создаёт экземпляр класса
     * @param Doctor_Service_SqlDatabase_MySql_DriverInterface $driver драйвер базы данных
     * @param Doctor_Service_SqlDatabase_RowTransformer_RowTransformerFactory $rowTransformerFactory фабрика преобразователей табличных данных
     */
    public function __construct(
        Doctor_Service_SqlDatabase_MySql_DriverInterface $driver,
        Doctor_Service_SqlDatabase_RowTransformer_RowTransformerFactory $rowTransformerFactory
    ) {
        
        $this->driver = $driver;
        $this->rowTransformerFactory = $rowTransformerFactory;
        
    }
    
    // Doctor_Service_SqlDatabase_AdapterInterface: START ----------------------

    public function fetchNothing($query) {
        
        $this->driver->fetchNothing($query);
        
    }

    public function fetchRows($query) {
        
        $rows = $this->driver->fetchRows($query);
        
        return $rows;
        
    }

    public function fetchNumberOfAffectedRows($query) {
        
        return $this->driver->fetchNumberOfAffectedRows($query);
        
    }

    public function fetchLastId($query) {
        
        return $this->driver->fetchLastId($query);
        
    }

    public function fetchDefaultId($tableName, $idColumn, array $values = array()) {
        
        $values[$idColumn] = 'DEFAULT';
        
        $fields = array();
        foreach (array_keys($values) as $field) {
            $fields[] = '`' . $field . '`';
        }
        
        $id = $this->fetchLastId('
            INSERT INTO `'.$tableName.'`(
                '.implode(', ', $fields).'
            )
            VALUES (
                '.implode(', ', array_values($values)).'
            )
            ;
        ');
        
        return $id;
        
    }

    public function fetchFirstRow($query) {

        return $this->makeRowTransformer($query)->fetchFirstRow();
        
    }

    public function fetchColumns($query) {
        
        return $this->makeRowTransformer($query)->fetchColumns();
        
    }

    public function fetchColumn($query, $fieldName) {
        
        return $this->makeRowTransformer($query)->fetchColumn($fieldName);
        
    }

    public function fetchValueFromFirstRow($query, $fieldName) {
        
        return $this->makeRowTransformer($query)->fetchValueFromFirstRow($fieldName);
        
    }

    public function beginTransaction() {

        // http://www.mysql.ru/docs/man/COMMIT.html
        
        $this->driver->fetchNothing('SET AUTOCOMMIT=0;');
        
		$this->driver->fetchNothing('BEGIN;');
        
    }

    public function commit() {
        
        $this->driver->fetchNothing('COMMIT;');
        
        $this->driver->fetchNothing('SET AUTOCOMMIT=1;');

    }

    public function rollback() {
        
        $this->driver->fetchNothing('ROLLBACK;');
        
        $this->driver->fetchNothing('SET AUTOCOMMIT=1;');
        
    }

    public function prepareString($value) {
        
        return $this->driver->prepareString($value);
        
    }

    public function prepareBoolean($value) {
        
        return $value ? 'TRUE' : 'FALSE';
        
    }

    public function prepareIfNull($value) {
        
        return is_null($value) ? 'NULL' : $value;
        
    }

    public function castBoolean(&$value) {
        
        $value = (bool)$value;
        
    }
    
    // Doctor_Service_SqlDatabase_AdapterInterface: STOP ----------------------
    
    private function makeRowTransformer($query) {
        
        $rows = $this->fetchRows($query);
        
        return $this->rowTransformerFactory->makeRowTransformer($rows);
        
    }
    
}