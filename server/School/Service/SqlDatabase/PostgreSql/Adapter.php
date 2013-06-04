<?php
class School_Service_SqlDatabase_PostgreSql_Adapter 
implements
    School_Service_SqlDatabase_AdapterInterface
{
    
    private $driver;
    
    private $rowTransformerFactory;
    
    public function __construct(
        School_Service_SqlDatabase_PostgreSql_DriverInterface $driver,
        School_Service_SqlDatabase_RowTransformer_RowTransformerFactory $rowTransformerFactory
    ) {
        
        $this->driver = $driver;
        $this->rowTransformerFactory = $rowTransformerFactory;
        
    }
    
    
}