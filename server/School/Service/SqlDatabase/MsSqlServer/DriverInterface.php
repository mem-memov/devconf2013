<?php
interface School_Service_SqlDatabase_MsSqlServer_DriverInterface {
    
    /**
     * Выполняет запрос к базе данных
     * @param string $query текст SQL-запроса
     * @throws School_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchNothing($query);
    
    /**
     * Извлекает строки таблицы
     * @param string $query текст SQL-запроса
     * @return array
     * @throws School_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchRows($query);
    
    /**
     * Сообщает количество изменённых в последнем запросе строк
     * @param string $query текст SQL-запроса
     * @return int
     * @throws School_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchNumberOfAffectedRows($query);
    
    /**
     * Находит идентификатор добавленной записи
     * @param string $query текст SQL-запроса
     * @return int
     * @throws School_Service_SqlDatabase_Exception_QueryFailed
     */
    public function fetchLastId($query);
    
}