<?php

namespace Etah\Cms\Component\Article\Common2;

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
		$title->setLabel('组件标题');
		$title->setName('component_title');
		$title->setValue('新闻动态');
		
		$CharacterLimit = new Text();
		$CharacterLimit->setLabel('文章标题最大长度');
		$CharacterLimit->setName('character_limit');
		$CharacterLimit->setValue(30);
		
		$article_ids = new Text();
		$article_ids->setLabel('文章id号');
		$article_ids->setName('article_ids');
		$article_ids->setValue('1,2,3');
		
		
		$this->add($title);
		$this->add($CharacterLimit);
		$this->add($article_ids);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>