<?php
/**
 * Кэш-заглушку
 */
class Doctor_Service_Cache_Dummy implements Doctor_Service_Interface_Cache {
    
    public function get($key) {
        
        return null;
        
    }
    
    public function set($key, $value) {}
    
    public function delete($key) {}
    
}