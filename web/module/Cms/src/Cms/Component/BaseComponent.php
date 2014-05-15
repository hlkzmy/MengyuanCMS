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
	
	/**
	 * 页面中每个地方的所使用的模板可能并不一样，但是里面的内容是一样的
	 * 这个时候在一个模板中写很多的判断语句就有一点不合算，
	 * 让用户直接设置完整的模板路径难度又太大，所以设置一个组件模板的编号是最简单的
	 */
	public function setTemplateStyle($styleNumber){
		
		$class = static::class;
		
		$namespace =  substr($class,0,strrpos($class, '\\'));
		$namespace =  str_replace('\\', '/',$namespace);
		
		$this->setTemplate(sprintf('%s/Template/Style%s',$namespace,$styleNumber));
		return $this;
	}
	
	
    
}