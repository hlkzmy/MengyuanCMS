<?php

namespace Etah\Cms\Component\Rankings\VideoSortRanking;


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
		
		$videoSort = new Text();
		$videoSort->setLabel('视频分类ID');
		$videoSort->setName('video_sort_id');
		
		
		$method = new Select();
		$method->setLabel('排名方式');
		$method->setName('rankMethod');
		$method->setValueOptions(array(
				
				'pv'=>'点击量',
				'score'=>'评分',
				'add_time'=>'添加时间'
				));
		
		
		$CharacterLimit = new Text();
		$CharacterLimit->setLabel('标题最大长度');
		$CharacterLimit->setName('character_limit');
		$CharacterLimit->setValue(30);
		
		
		$limit = new Text();
		$limit->setLabel('显示总数');
		$limit->setName('limit');
		$limit->setValue(5);
		
		$this->add($videoSort);
		$this->add($method);
		$this->add($CharacterLimit);
		$this->add($limit);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>