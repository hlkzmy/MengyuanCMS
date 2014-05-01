<?php

namespace Courseware\Form;
use Etah\Mvc\Form\BaseForm;;



class CoursewareForm extends BaseForm
{
	public function __construct($name = null)
	{
		parent::__construct('CoursewareForm');
		
		$this->setAttribute('enctype',  'multipart/form-data');
		
		$this->setAttribute('onsubmit',  'return iframeCallback(this,navTabAjaxDone);');
		
	}//function __construct() end
	
	
}
