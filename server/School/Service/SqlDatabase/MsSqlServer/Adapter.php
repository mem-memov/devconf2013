<?php
class School_Service_SqlDatabase_MsSqlServer_Adapter 
implements
    School_Service_SqlDatabase_AdapterInterface
{
    
    /**
     * Драйвер базы данных
     * @var School_Service_SqlDatabase_MsSqlServer_DriverInterface
     */
    private $driver;
    
    /**
     * Фабрика преобразователей табличных данных
     * @var School_Service_SqlDatabase_RowTransformer_RowTransformerFactory
     */
    private $rowTransformerFactory;
    
    /**
     * Создаёт экземпляр класса
     * @param School_Service_SqlDatabase_MsSqlServer_DriverInterface $driver драйвер базы данных
     * @param School_Service_SqlDatabase_RowTransformer_RowTransformerFactory $rowTransformerFactory фабрика преобразователей табличных данных
     */
    public function __construct(
        School_Service_SqlDatabase_MsSqlServer_DriverInterface $driver,
        School_Service_SqlDatabase_RowTransformer_RowTransformerFactory $rowTransformerFactory
    ) {
        
        $this->driver = $driver;
        $this->rowTransformerFactory = $rowTransformerFactory;
        
    }
    
    // School_Service_SqlDatabase_AdapterInterface: START ----------------------

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
        foreach (array_keys($columnValues) as $field) {
            $fields[] = '[' . $field . ']';
        }
        
        $id = $this->fetchLastId('
            INSERT INTO ['.$tableName.'](
                '.implode(', ', array_keys($columnValues)).'
            )
            VALUES (
                '.implode(', ', array_values($columnValues)).'
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
        
		$this->driver->fetchNothing('BEGIN TRANSACTION');
        
    }

    public function commit() {
        
		$this->driver->fetchNothing('COMMIT');
        
    }

    public function rollback() {
        
		$this->driver->fetchNothing('ROLLBACK');
        
    }

    public function prepareString($value) {

        return '\"'. addslashes($value) . '\"';
        
    }

    public function prepareBoolean($value) {
        
        return $value ? '1' : '0';
        
    }

    public function prepareIfNull($value) {
        
        return is_null($value) ? 'NULL' : $value;
        
    }

    public function castBollean(&$value) {

        $value = (bool)$value;
        
    }
    
    // School_Service_SqlDatabase_AdapterInterface: STOP ----------------------
    
    private function makeRowTransformer($query) {
        
        $rows = $this->fetchRows($query);
        
        return $this->rowTransformerFactory->makeRowTransformer($rows);
        
    }
    
}