<?php
/**
 * Фабрика контроллеров
 */
class School_ExtDirect_Factory_Controller extends School_ExtDirect_Abstract_Factory {
    
    /**
     * Создаёт контроллер
     * @param type $class
     * @return CRemote_Abstract_Base
     */
    public function getController($class) {
        
        return new $class($this->factory, $this->factory->getCache());
        
    }
    
}
