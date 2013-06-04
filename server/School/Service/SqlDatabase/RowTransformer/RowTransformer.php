<?php
/**
 * Преобразователь табличных данных
 */
class School_Service_SqlDatabase_RowTransformer_RowTransformer {
    
    private $rows;
    private $isEmpty;
    
    /**
     * Создаёт экземпляр
     * @param array $rows массив, состоящий из однотипных ассоциативных массивов
     */
    public function __construct(array $rows) {
        
        $this->rows = $rows;
        $this->isEmpty = empty($rows);
        
    }
    
    /**
     * Извлекает первую строку
     * @return array
     */
    public function fetchFirstRow() {
        
        if ($this->isEmpty) {
            return array();
        }
            
        return $this->rows[0];

    }
    
    /**
     * Преобразует строки в колонки
     * @return array
     */
    public function fetchColumns() {
        
        if ($this->isEmpty) {
            return array();
        }
        
        $columns = array();
        
        foreach ($this->rows as $row) {
            
            foreach ($row as $field => $value) {
                
                $columns[$field][] = $value;
                
            }
            
        }

        return $columns;
        
    }
    
    /**
     * Возвращает определённую колонку
     * @param string $fieldName имя поля
     * @return array
     */
    public function fetchColumn($fieldName) {
        
        if ($this->isEmpty) {
            return array();
        }
        
        $firstRow = $this->fetchFirstRow();
        
        if (!array_key_exists($fieldName, $firstRow)) {
            return array();
        }
        
        $columns = $this->fetchColumns();
        
        if (empty($columns)) {
            return array();
        }
        
        return $columns[$fieldName];
        
    }
    
    /**
     * Извлекает значение из определённого поля первой строки
     * @param string $fieldName имя поля
     * @return mixed|null
     */
    public function fetchValueFromFirstRow($fieldName) {
        
        if ($this->isEmpty) {
            return null;
        }
        
        $firstRow = $this->fetchFirstRow();
        
        if (!array_key_exists($fieldName, $firstRow)) {
            return null;
        }
        
        return $firstRow[$fieldName];
        
    }
    
    
    
}