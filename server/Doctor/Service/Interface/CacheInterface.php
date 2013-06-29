<?php
interface Doctor_Service_Interface_Cache {
    
    public function get($key);
    public function set($key, $value);
    public function delete($key);
    
}