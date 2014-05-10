<?php

namespace Etah\Cms\Component\evaluation\Common;

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
		
		
		$title_name = new Text();
		$title_name->setLabel('标题');
		$title_name->setName('title_name');
		$title_name->setValue('教学评价');
		
		
		$limit = new Text();
		$limit->setLabel('显示总数');
		$limit->setName('limit');
		$limit->setValue(8);
		
		$this->add($title_name);
		$this->add($limit);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>