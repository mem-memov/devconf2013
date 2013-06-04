<?php
/**
 * Автозагрузчик классов PHP
 */
class School_ExtDirect_ClassLoader {
    
    /** 
     * Путь к корневому каталогу
     * @var string  
     */
    private $root;
    
    /**
     * Создаёт экземпляр класса
     */
    public function __construct($pathToRootDirectory) {

        $this->root = $pathToRootDirectory;

    }
    
    public function start() {
        
        spl_autoload_register(array($this, 'autoload'));
        
    }

    /**
     * Выполняет автоматическую подгрузку файлов с классами
     * @param string $class имя класса
     * @throws School_ExtDirect_Exception
     */
    public function autoload($class) {

        $path = $this->buildUnderscoreClassPath($class);
        
        if (is_readable($path)) {
            
            require_once($path);
            
        } else {
            
            var_dump($path);
            
            throw new School_ExtDirect_Exception('Файл "'.$path.'" не найден для класса "'.$class.'".');
            
        }

    }
    
    /**
     * Строит путь к файлу с классом
     * @param string $class
     * @return string 
     */
    private function buildUnderscoreClassPath($class) {

        $path = $this->root.'/'.str_replace('_', '/', $class).'.php';

        return $path;
        
    }
    
}