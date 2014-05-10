<?php

namespace Etah\Cms\Component\Comment\Forvideo;

use Zend\Form\Element\Select;

use Zend\Form\Element\Hidden;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\MultiCheckbox;

class Config extends Form{
	
	function __construct(){
		
		parent::__construct('ConfigForm');
		
		$this->setAttribute('method'	,'post');
		$this->setAttribute('class'		,'pageForm required-validate');
		$this->setAttribute('onsubmit'	,'return validateCallback(this)');
		
		
		$Limit = new Text();
		$Limit->setLabel('每页评论显示的条目数');
		$Limit->setName('limit');
		$Limit->setValue(8);
		
		
		$type = new Select();
		$type->setLabel('请选择评论显示方式');
		$type->setName('type');
		$type->setValueOptions(
				array(
						'0'=>'按时间从近到远排列',
						'1'=>'按回复数从高到低排列'
						)
				);
		
	  
		$this->add($Limit);
		$this->add($type);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>