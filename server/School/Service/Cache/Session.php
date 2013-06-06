<?php
/**
 * Кэш, основанный на PHP-сессиях
 */
class CModel_Service_Cache_Session implements School_Service_Interface_Cache {
    
    public function __construct() {
        
        session_id('cache');
        session_start();
        
    }
    
    public function __destruct() {
        
        session_write_close();
        
    }
    
    public function get($key) {
  
        if (array_key_exists($key, $_SESSION)) {
            return unserialize($_SESSION[$key]);
        } else {
            return null;
        }
        
    }
    
    public function set($key, $value) {
        
        $_SESSION[$key] = serialize($value);
        
    }
    
    public function delete($key) {

        unset($_SESSION[$key]);
        
    }
    
}