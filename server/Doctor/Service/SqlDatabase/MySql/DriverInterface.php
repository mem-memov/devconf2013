<?php
interface Doctor_Service_SqlDatabase_MySql_DriverInterface {
    
    /**
     * Выполняет запрос к базе данных
     * @param string $query текст SQL-запроса
     * @throws Doctor_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchNothing($query);
    
    /**
     * Извлекает строки таблицы
     * @param string $query текст SQL-запроса
     * @return array
     * @throws Doctor_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchRows($query);
    
    /**
     * Сообщает количество изменённых в последнем запросе строк
     * @param string $query текст SQL-запроса
     * @return int
     * @throws Doctor_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchNumberOfAffectedRows($query);
    
    /**
     * Находит идентификатор добавленной записи
     * @param string $query текст SQL-запроса
     * @return int
     * @throws Doctor_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchLastId($query);
    
    /**
     * Подготавливает строковое значение для вставки в запрос
     * @param str $value
     */
    public function prepareString($value);
    
}