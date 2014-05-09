<?php

define('VENDOR_PATH', dirname(__DIR__) . '/vendor');

include VENDOR_PATH . '/ZF2/library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(
	array(
	    'Zend\Loader\StandardAutoloader' => array('autoregister_zf' => true),
	)
);

$autoloader = Zend\Loader\AutoloaderFactory::getRegisteredAutoloaders();
$autoloader = $autoloader[Zend\Loader\AutoloaderFactory::STANDARD_AUTOLOADER];

