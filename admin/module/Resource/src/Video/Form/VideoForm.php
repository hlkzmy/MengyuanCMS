<?php

namespace Video\Form;
use Zend\Form\Form;
use Zend\Form\Element\Hidden;

use Etah\Mvc\Form\BaseForm;;



class VideoForm extends BaseForm
{
	public function __construct($name = null)
	{
		parent::__construct('VideoForm');
		
		
		$uploadFlag = new Hidden('upload_flag');
		$uploadFlag->setAttribute('id', 'upload_flag');
		
		$this->add($uploadFlag);
		
	}//function __construct() end
	
	
	
}
