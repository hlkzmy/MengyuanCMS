<?php

namespace Information;


class Module
{
	public function getConfig()
    {
    	$moduleConfig = include __DIR__ . '/config/module.config.php';
    	
  		$configFileList = array(
    							'read'=>'read.config.php',
    							'create'=>'create.config.php',
    							'update'=>'update.config.php',
    							'delete'=>'delete.config.php',
    							'ajax'=>'ajax.config.php',
    							'checkcreate' =>'checkcreate.config.php',
    							'checkupdate'=>'checkupdate.config.php',
    							'upload'=>'upload.config.php'
    					  ); 
    	
    	foreach($configFileList as $configKey=>$configFile){
    		
    		$configFilePath = dirname(__FILE__).'/config/'.$configFile;
    		//得到加载的页面配置文件的路径
    		 
    		if(!file_exists($configFilePath))continue;
    		
    		$configFileArray = include $configFilePath;
    		//得到配置文件的里面所包含的数组
    		
    		
    		
    		if(isset($moduleConfig[$configKey])){
            //如果之前page数组已经存在的话，那么就不需要创建
    			
    			$intersectArray = array_intersect_key($moduleConfig[$configKey],$configFileArray);
    			//把全局的page页面数组与配置数组求交集
    			
    			if(sizeof($intersectArray)>0){
    			//如果存在交集，那么就意味着存在配置文件中配置数组的键值冲突	
    				print_r($intersectArray);
    				
    				die('以上数组为在加载配置文件的时候发生的冲突数组');
    			}
    			else{
    			//如果不存在冲突的话，就直接进行合并	
    				$moduleConfig[$configKey] = array_merge($moduleConfig[$configKey],$configFileArray);
    			}
    		
    		}
    		else{
    	    //如果page数组在之前不存在的话，那么就创建数组，并且直接把配置数组赋值给page数组		
    				$moduleConfig[$configKey] = $configFileArray;
    		}
    		
    	}//foreach end
    	
    	return $moduleConfig;
    }
    
	public function getServiceConfig()
    {
    	return include __DIR__ . '/config/server.config.php';
    	
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                	'User' 		  => __DIR__ . '/src/' . 'User',
                	'School'      => __DIR__ . '/src/' . 'School',
                ),
            ),
        );
    }

}
