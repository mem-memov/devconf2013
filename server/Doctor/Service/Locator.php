<?php
/**
 * Поставщик сервисов
 */
class Doctor_Service_Locator {
    
    private $config;
    private $factory;
    
    public function __construct(
        array $config,
        Doctor_Service_Factory $factory
    ) {
        
        $this->config = $config;
        $this->factory = $factory;
        
    }
    
    public function getApiGenerator() {
        
        $config = $this->config['генератор API'];

        $siteRootOffset = $config['путь от корневой директории сайта до директории приложения'];
        
        return $this->factory->makeApiGenerator($siteRootOffset);
        
    }
    
    public function getDatabase() {
        
        $config = $this->config['база данных'];
        
        $type = $config['тип (MySQL/PostgreSQL/MS SQL Server)'];
        $server = $config['сервер'];
        $port = $config['порт (номер/нет)'];
        $user = $config['пользователь'];
        $password = $config['пароль'];
        $database = $config['база'];
        $schema = $config['схема (имя/нет)'];
        $encoding = $config['кодировка'];
        
        switch ($type) {
            
            case 'MySQL':
                $database = $this->factory->makeSqlDatabaseFactory()->makeMySqlAdapter(
                    $server, 
                    $port, 
                    $user, 
                    $password, 
                    $database, 
                    $encoding
                );
                break;
            
            case 'PostgreSQL':
                $database = $this->factory->makeSqlDatabaseFactory()->makePostgreSqlAdapter(
                    $server, 
                    $port, 
                    $user, 
                    $password, 
                    $database, 
                    $encoding, 
                    $schema != 'нет' ? $schema : null
                );
                break;
            
            case 'MS SQL Server':
                $database = $this->factory->makeSqlDatabaseFactory()->makeMsSqlServerAdapter(
                    $server,
                    $user, 
                    $password, 
                    $database, 
                    $encoding
                );
                break;
            
            default:
                throw new Doctor_Service_Exception('Неизвестный тип базы данных: '.$type);
                break;
            
        }
        
        return $database;
        
    }
    
    public function getTreeMaker(array &$rows) {
        
        return $this->factory->makeTreeMaker($rows);
        
    }
    
}