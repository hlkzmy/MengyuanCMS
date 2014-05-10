<?php

defined('VENDOR_PATH') || define('VENDOR_PATH',dirname(dirname(__DIR__))  . '/vendor');


include VENDOR_PATH . '/ZF2/Library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(
array(
    'Zend\Loader\StandardAutoloader' => array('autoregister_zf' => true),
)
);

$autoloader = Zend\Loader\AutoloaderFactory::getRegisteredAutoloaders();
$autoloader = $autoloader[Zend\Loader\AutoloaderFactory::STANDARD_AUTOLOADER];

$autoloader->registerNamespace('Etah\\', VENDOR_PATH.'/ETAH' );
$autoloader->registerNamespace('Org\\' , VENDOR_PATH.'/ORG' );