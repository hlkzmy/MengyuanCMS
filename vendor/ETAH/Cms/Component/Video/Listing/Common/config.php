<?php

namespace Etah\Cms\Component\Video\Listing\Common;

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
		$videoSortId->setLabel('视频分类编号');
		$videoSortId->setName('video_sort_id');
		$videoSortId->setValue(1);
		
		
		$limit = new Text();
		$limit->setLabel('显示总数');
		$limit->setName('limit');
		$limit->setValue(8);
		
		$perRowCount = new Text();
		$perRowCount->setLabel('每行个数');
		$perRowCount->setName('per_row_count');
		$perRowCount->setValue(4);
		
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
		
		$columns->setValue(array('id','name','thumb'));
	  
		
		$this->add($videoSortId);
		$this->add($limit);
		$this->add($perRowCount);
		$this->add($columns);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>