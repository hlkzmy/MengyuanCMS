<?php

namespace Etah\Cms\Component\liveClassRoom\Common;
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
		
		
		$title = new Text();
		$title->setLabel('显示的标题');
		$title->setName('title');
		$title->setValue('直播课堂');
		
		$classroomLimit = new Text();
		$classroomLimit->setLabel('教室显示个数');
		$classroomLimit->setName('limit');
		$classroomLimit->setValue(1);
	  
		$this->add($classroomLimit);
		$this->add($title);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>