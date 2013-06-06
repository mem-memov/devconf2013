<?php
header('Content-type: text/html; charset=utf-8'); 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once('School/ExtDirect/Factory.php');

School_ExtDirect_Factory::construct(
    require_once('config.php')
)->makeServiceLocator()
->getApiGenerator()
->generate();
