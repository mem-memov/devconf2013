<?php
/**
 * Запрос от формы
 */
class School_ExtDirect_Request_Form extends School_ExtDirect_Abstract_Request {
    
    /**
     * Информация о загруженных файлах
     * @var array 
     */
    protected $aFiles;
    
    /**
     * Флаг загрузки файла
     * @var boolean
     */
    protected $isUpload;
    
    /**
     * Создаёт экземпляр класса 
     */
    public function __construct() {
        
        // рабочие параметры свойства получат при инициализации
        
        $this->transactionId = null;
        $this->class = null;
        $this->method = null;
        $this->parameters = null;
        $this->isUpload = null;
        $this->type = null;
        
        $this->files = null;
        
    }
    
    /**
     * Инициализирует объект
     * 
     * @param array $values
     * @return School_ExtDirect_Request_Form 
     */
    public function initialize(array $values) {

        // ограничиваем набор параметров, приходящих от клиента
        $rpcParameters = array(
            'extType', // тип запроса
            'extAction', // имя класса
            'extMethod', // имя метода
            'extUpload', // флаг загрузки файла
            'extTID' // ID запроса
        );
        
        // объявляем контейнер для параметров вызова
        $rpcValues = array();

        // собираем значения параметров вызова
        foreach ($rpcParameters as $rpcParameter) {

            if (isset($values[$rpcParameter])) {
                $rpcValues[$rpcParameter] = $values[$rpcParameter];
            } else {
                $rpcValues[$rpcParameter] = ''; // определяем значение по умолчанию
            }

        }
        
        // объявляем контейнер для данных из полей формы
        $formValues = array();
        
        // собираем данные
        foreach ($values as $lsKey => $lsValue) {

            if (!isset($rpcParameters[$lsKey])) {
                $formValues[$lsKey] = $lsValue;
            }
            
        }
        
        // Инициализируем свойства объекта
        $this->transactionId = $rpcValues['extTID'];
        $this->class = $rpcValues['extAction'];
        $this->method = $rpcValues['extMethod'];
        $this->parameters = $formValues;
        $this->isUpload = ($rpcValues['extUpload'] == 'true');
        $this->type = $rpcValues['extType'];
        
        // Первичная инициализация сведений о загруженных файлах.  См. set_files()
        $this->files = array();
        
        // Разрешаем цепочки вызывов
        return $this;

    }
    
    /**
     * Добавляет информацию о загруженных файлах
     * 
     * @param array $files $_FILES
     */
    public function setFiles(array $files) {
        
        $this->files = $files;
        
    }
    
    /**
     * Проверяет правильность запроса
     * 
     * @return boolean 
     */
    public function isValid() {

        return (
             $this->type == 'rpc'
             && !empty($this->class)
             && !empty($this->method)
        );
        
    }
    
    /**
     * Предоставляет сведения о загруженных файлах
     * 
     * @return array 
     */
    public function getFiles() {
        
        return $this->files;
        
    }
    
    /**
     * Показывает, сопровождается ли запрос загрузкой файла
     * 
     * @return boolean 
     */
    public function isUpload() {
        
        return $this->isUpload;
        
    }
    
}
