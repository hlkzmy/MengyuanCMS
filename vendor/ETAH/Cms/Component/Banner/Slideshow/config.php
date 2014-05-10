<?php

namespace Etah\Cms\Component\Banner\Slideshow;

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
		
		
		
		$bannerType = new Select();
		$bannerType->setLabel('幻灯片类型');
		$bannerType->setName('bannerType');
		$bannerType->setValueOptions(array('new'=>'最新视频','hot'=>'热门视频'));
		
		
		$limit = new Text();
		$limit->setLabel('显示数量');
		$limit->setName('limit');
		$limit->setValue(8);
		
		
		$columns = new MultiCheckbox();
		$columns->setLabel('显示字段');
		$columns->setName('columns');
		$columns->setValueOptions(array(
		
				'id'=>'视频编号',
		
				'name'=>'视频名称',
		
				'thumb'=>'视频缩略图',
		
				'chapter_count'=>'章节数',
		
				'pv'=>'浏览量',
		
				'score'=>'视频得分',
		
				'add_time'=>'添加时间'
		
		));
		
		$this->add($columns);
		$this->add($bannerType);
		$this->add($limit);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>