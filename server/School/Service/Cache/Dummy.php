<?php
/**
 * Кэш-заглушку
 */
class School_Service_Cache_Dummy implements School_Service_Interface_Cache {
    
    public function get($key) {
        
        return null;
        
    }
    
    public function set($key, $value) {}
    
    public function delete($key) {}
    
}