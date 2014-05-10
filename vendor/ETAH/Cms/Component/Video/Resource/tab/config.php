<?php

namespace Etah\Cms\Component\Video\Resource\tab;
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
		
		$columns = new MultiCheckbox();
		$columns->setLabel('显示资源');
		$columns->setName('columns');
		$columns->setValueOptions(array(
		
				'video'=>'视频',
		
				'courseware'=>'课件',
		
		));
		
		$columns->setValue(array('video','courseware'));
		
		
		$videoLimit = new Text();
		$videoLimit->setLabel('视频显示总数');
		$videoLimit->setName('video_limit');
		$videoLimit->setValue(8);
		
		$perRowCount = new Text();
		$perRowCount->setLabel('视频每行个数');
		$perRowCount->setName('per_row_count');
		$perRowCount->setValue(2);
		
		
		$coursewareLimit = new Text();
		$coursewareLimit->setLabel('课件显示总数');
		$coursewareLimit->setName('courseware_limit');
		$coursewareLimit->setValue(8);
	  
		$this->add($columns);
		$this->add($videoLimit);
		$this->add($perRowCount);
		$this->add($coursewareLimit);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>