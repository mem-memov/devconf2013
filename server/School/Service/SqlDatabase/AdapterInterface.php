<?php
class School_Service_SqlDatabase_AdapterInterface {
    
    /**
     * Выполняет SQL-запрос
     * @param string $query SQL-запрос
     * @return null
     */
    public function query($query);
    
    /**
     * Извлекает строки таблицы
     * @param string $query SQL-запрос
     * @return array
     */
    public function fetchRows($query);
    
    /**
     * Извлекает первую строку
     * @param string $query SQL-запрос
     * @return array
     */
    public function fetchFirstRow($query);
    
    /**
     * Извлекает колонки
     * @param string $query SQL-запрос
     * @return array
     */
    public function fetchColumns($query);
    
    /**
     * Возвращает определённую колонку
     * @param string $query SQL-запрос
     * @param string $fieldName имя поля
     * @return array
     */
    public function fetchColumn($query, $fieldName);
    
    /**
     * Извлекает значение из определённого поля первой строки
     * @param string $query SQL-запрос
     * @param string $fieldName имя поля
     * @return mixed|null
     */
    public function fetchValueFromFirstRow($query, $fieldName);
    
}