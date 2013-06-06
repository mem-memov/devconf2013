<?php
/**
 * Файловый кэш
 */
class School_Service_Cache_File implements School_Service_Interface_Cache {
    
    private $cache;
    private $path;
    
    public function __construct() {

        $tmpDirectory = __DIR__.'/../../../../tmp';
        $file = 'codecache.php';
        $this->path = $tmpDirectory . '/' . $file;
        
        if (!is_writable($tmpDirectory)) {
            throw new Exception('У PHP нет прав на запись в директорию ' . $tmpDirectory);
        }

        if (!file_exists($this->path)) {
            file_put_contents($this->path, '<?php return ' . var_export(array(), true) . ';' );
        }
        
        $this->cache = require_once($this->path);
        
    }
    
    public function __destruct() {
        
        file_put_contents($this->path, '<?php return ' . var_export($this->cache, true) . ';' );
        
    }
    
    public function get($key) {
  
        if (array_key_exists($key, $this->cache)) {
            return unserialize($this->cache[$key]);
        } else {
            return null;
        }
        
    }
    
    public function set($key, $value) {
        
        $this->cache[$key] = serialize($value);
        
    }
    
    public function delete($key) {

        unset($this->cache[$key]);
        
    }
    
}