<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Cms;


class Module
{
    
	public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
     
    public function getServiceConfig()
    {
    	
    	$path = realpath(__DIR__.'/src');//源码库的位置
    	 
    	$objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

    	$serviceConfig = array();
    	
    	foreach ($objects as $path =>$object) {
    		
    		if(is_file($path)&&is_readable($path)){
    			$fileName = basename($path);
    			if(strtolower($fileName)=='service.config.php'){
    				$config = include_once $path;
    				if(is_array($config)&&sizeof($config)>0){
    					$serviceConfig = array_merge_recursive($serviceConfig,$config);
    				}
    			}
    		}
    	}//foreach end
    	
    	return $serviceConfig;
    }
    
   
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
