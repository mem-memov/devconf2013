<?php
/**
 * Взаимодействие
 * 
 *  
 */
abstract class Doctor_ExtDirect_Abstract_Transaction {
    
    /**
     * Числовой идентификатор взаимодействия
     * 
     * @var integer 
     */
    protected $transactionId;
    
    /**
     * Возвращает числовой идентификатор взаимодействия
     *
     * @return integer 
     */
    public function getTransactionId() {
        
        return $this->transactionId;
        
    }
    
}
