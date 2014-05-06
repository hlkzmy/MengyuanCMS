<?php

namespace Web;


class Module1
{
    
	public function init(){
		echo 'init<br/>';
		return array();
	}
	
	public function getConfig()
    {
       	echo 'getConfig<br/>';
       	return array();
    }
    
    public function getServiceConfig()
    {
    	
    	echo 'getServiceConfig<br/>';
    	return array();
    }
    
	public function getAutoloaderConfig()
    {
    	echo 'getAutoloaderConfig<br/>';
    	return array();
    }
    
    public function onBootstrap(){
    	echo 'onBootstrap<br/>';
    	return array();
    }
    
    public function getConsoleBanner(){
    	echo 'getConsoleBanner<br/>';
    	return array();
    }
    
    public function getConsoleUsage(){
    	echo 'getConsoleUsage<br/>';
    	return array();
    }
    
    public function getControllerPluginConfig(){
    	echo 'getControllerPluginConfig<br/>';
    	return array();
    }
    
    public function getControllerConfig(){
    	echo 'getControllerConfig<br/>';
    	return array();
    }
    
    public function getModuleDependencies(){
    	echo 'getModuleDependencies<br/>';
    	return array();
    }
    
    public function getFilterConfig(){
    	echo 'getFilterConfig<br/>';
    	return array();
    }
    
    public function getFormElementConfig(){
    	echo 'getFormElementConfig<br/>';
    	return array();
    }
    
    public function getHydratorConfig(){
    	echo 'getHydratorConfig<br/>';
    	return array();
    }
    
    public function getInputFilterConfig(){
    	echo 'getInputFilterConfig<br/>';
    	return array();
    }
    
    public function getRouteConfig(){
    	echo 'getRouteConfig<br/>';
    	return array();
    }
    
    public function getSerializerConfig(){
    	echo 'getSerializerConfig<br/>';
    	return array();
    }
    
    public function getValidatorConfig(){
    	echo 'getValidatorConfig<br/>';
    	return array();
    }
    
    public function getViewHelperConfig(){
    	echo 'getViewHelperConfig<br/>';
    	return array();
    }
    
}
