<?php
/**
 * Запрос из пакета
 */
class School_ExtDirect_Request_Batch extends School_ExtDirect_Abstract_Request {

    public function __construct() {
        
        $this->transactionId = null;
        $this->class = null;
        $this->method = null;
        $this->parameters = null;
        $this->type = null;
        
    }
    
    public function initialize(array $values) {
        
        // ограничиваем набор параметров, приходящих от клиента
        $rpcParameters = array(
            'type', // тип запроса
            'action', // имя класса
            'method', // имя метода
            'data', // массив значений
            'tid' // ID запроса
        );
        
        $rpcValues = array();

        // собираем значения параметров вызова 
        foreach ($rpcParameters as $rpcParameter) {

            if (isset($values[$rpcParameter])) {
                $rpcValues[$rpcParameter] = $values[$rpcParameter];
            } else {
                $rpcValues[$rpcParameter] = '';
            }

        }
        
        if ($rpcValues['data'] == '') {
            $rpcValues['data'] = array();
        }

        // Инициализируем свойства объекта
        $this->transactionId = $rpcValues['tid'];
        $this->class = $rpcValues['action'];
        $this->method = $rpcValues['method'];
        $this->parameters = $rpcValues['data'];
        $this->type = $rpcValues['type'];
        
    }

    public function isValid() {
        
        return (
             $this->type == 'rpc'
             && !empty($this->class)
             && !empty($this->method)
        );
        
    }

}
