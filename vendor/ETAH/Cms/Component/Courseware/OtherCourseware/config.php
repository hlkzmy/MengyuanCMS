<?php

namespace Etah\Cms\Component\courseware\OtherCourseware;

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
		
		
		$type = new Select();
		$type->setLabel('设置课件组件的显示模式');
		$type->setName('type');
		$type->setValueOptions(
				array(
						'bysort'=>'显示同类别的课件',
						'byvideo'=>'显示同一视频下的其它课件',
						'all'=>'上述两项都显示'						
						)
				);
		
		$CharacterLimit = new Text();
		$CharacterLimit->setLabel('课件标题最大长度');
		$CharacterLimit->setName('character_limit');
		$CharacterLimit->setValue(30);
		
		
		$limit = new Text();
		$limit->setLabel('显示总数');
		$limit->setName('limit');
		$limit->setValue(8);
		
		
		$this->add($type);
		$this->add($CharacterLimit);
		$this->add($limit);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>