<?php
class School_Service_SqlDatabase_AdapterInterface {
    
    /**
     * Выполняет SQL-запрос
     * @param string $query SQL-запрос
     * @return null
     */
    public function query($query);
    
    /**
     * Вставляет новую строку в таблицу, имеющую одно поле с автоинкрементом
     * @param string $tableName имя таблицы
     * @param string $idColumn имя поля с автоинкрементом
     * @param array $values значения полей (могут содержать поле с автоинкрементом)
     */
    public function insertDefault($tableName, $idColumn, array $values = array());
    
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
    
    /**
     * Находит идентификатор добавленной записи
     * @return int|null
     */
    public function fetchLastId();
    
    /**
     * Сообщает количество изменённых в последнем запросе строк
     * @return int
     */
    public function fetchNumberOfAffectedRows();
    
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
     */
    public function castBollean($value);
    
}