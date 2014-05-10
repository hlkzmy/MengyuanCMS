<?php

namespace Etah\Cms\Component\Download\courseware;

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
		
		
		
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>