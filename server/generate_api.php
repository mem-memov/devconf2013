<?php
header('Content-type: text/html; charset=utf-8'); 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once('School/ExtDirect/Factory.php');
$factory = new School_ExtDirect_Factory();

$factory->makeClassLoader(__DIR__)->start();

$config = require_once('config.php');

$apiGenerator = $factory->makeServiceFactory()->makeApiGenerator(
    $config['генератор API']['путь от корневой директории сайта до директории приложения']
);
$apiGenerator->generate();