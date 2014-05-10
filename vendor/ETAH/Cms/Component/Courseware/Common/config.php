<?php

namespace Etah\Cms\Component\courseware\Common;

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
		
		
		$videoSortId = new Text();
		$videoSortId->setLabel('课件分类编号');
		$videoSortId->setName('courseware_sort_id');
		$videoSortId->setValue(1);
		
		$CharacterLimit = new Text();
		$CharacterLimit->setLabel('课件标题最大长度');
		$CharacterLimit->setName('character_limit');
		$CharacterLimit->setValue(30);
		
		
		$limit = new Text();
		$limit->setLabel('显示总数');
		$limit->setName('limit');
		$limit->setValue(8);
		
		
		$this->add($videoSortId);
		$this->add($CharacterLimit);
		$this->add($limit);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>