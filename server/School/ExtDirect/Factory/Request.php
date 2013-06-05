<?php
/**
 * Фабрика запросов
 */
class School_ExtDirect_Factory_Request extends School_ExtDirect_Abstract_Factory {
    
    /**
     * Создаёт пакетный запрос
     * @param array $values
     * @return School_ExtDirect_Request_Batch 
     */
    public function getBatchRequest(array $values) {
        
        $batchRequest = new School_ExtDirect_Request_Batch();
        $batchRequest->initialize($values);
        
        return $batchRequest;
        
    }
    
    /**
     * Создает запрос от веб-формы
     * @param array $values
     * @param array $files
     * @return School_ExtDirect_Request_Form 
     */
    public function getFormRequest(array $values, array $files) {
        
        $formRequest = new School_ExtDirect_Request_Form();
        $formRequest->initialize($values);
        $formRequest->setFiles($files);
        
        return $formRequest;
        
    }
    
}
