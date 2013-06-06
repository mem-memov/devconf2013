<?php
/**
 * Интерфейс адаптера базы данных
 */
interface School_Service_Interface_SqlDatabase {

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
    
    /**
     * Вставляет новую строку в таблицу, имеющую одно поле с автоинкрементом
     * @param string $tableName имя таблицы
     * @param string $idColumn имя поля с автоинкрементом
     * @param array $values значения полей (могут содержать поле с автоинкрементом)
     * @return int идентификатор вставленной строки
     */
    public function fetchDefaultId($tableName, $idColumn, array $values = array());

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
    
    /**
     * Начинает транзакцию
     */
    public function beginTransaction();
    
    /**
     * Записывает транзакцию
     */
    public function commit();
    
    /**
     * Отменяет транзакцию
     */
    public function rollback();
    
    /**
     * Подготавливает значение для вставки в SQL-запрос в качестве строки
     * Экранирует и оборачивает в кавычки.
     * @return string
     */
    public function prepareString($value);
    
    /**
     * Подготавливает булево значение для вставки в SQL-запрос
     * @return string
     */
    public function prepareBoolean($value);
    
    /**
     * Подготавливает переменную, которя может содержать null, для вставки в SQL-запрос
     * @return string
     */
    public function prepareIfNull($value);
    
    /**
     * Приводит значение, полученное из базы данных, к булеву типу
     * @return bool
     */
    public function castBollean(&$value);
    
}