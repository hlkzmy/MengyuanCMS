<?php

namespace Cms\Component\Article\BreadCrumb\Category;
use Cms\Component\Article\BreadCrumb\BreadCrumbContent;
use Cms\Component\ComponentInterface;


class Content extends BreadCrumbContent implements ComponentInterface{
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
}//class end



