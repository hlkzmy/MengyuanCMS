<?php

namespace Cms\Component;

use Zend\View\Model\ViewModel;//视图列表
use Zend\ServiceManager\ServiceLocatorInterface;//服务管理者的定义

abstract class BaseComponent extends ViewModel
{
    protected $serviceManager = null;//服务管理者对象
    
    
	public function __construct(ServiceLocatorInterface $serviceManager){
		
		if(is_null($this->serviceManager)){
			$this->serviceManager = $serviceManager;
		}
		
	}//function __construct();
	
	
	
	
    
}