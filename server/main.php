<?php
/**
 * Точка входа
 */
header('Content-type: text/html; charset=utf-8');

ini_set('memory_limit', 512217728);

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

ini_set('always_populate_raw_post_data', true);

require_once('School/ExtDirect/Factory.php');

try {
    
    list($headers, $contents) =     School_ExtDirect_Factory::construct(
                                        require_once('config.php')
                                    )->makeProcessor()
                                    ->process(
                                        $_SERVER['REQUEST_URI'],
                                        isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '',
                                        $_POST,
                                        $_FILES
                                    );
    
}
catch (Exception $e) {
    
    echo $e->getMessage();
    exit();
    
}

foreach ($headers as $header) {
    
    header($header);
    
}

echo $contents;