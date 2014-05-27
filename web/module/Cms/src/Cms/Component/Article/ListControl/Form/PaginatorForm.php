<?php

namespace Cms\Component\Article\ListControl\Form;

use Zend\Form\Form;
use Zend\Form\Element\Hidden;


class PaginatorForm extends Form
{
	
	
	public function __construct($name = null)
	{
		parent::__construct('paginator-form');
		
		$this->setAttribute('class','paginator-form');
		
		//新建常见的换页参数
		$currentPageNumber = new Hidden();
		$currentPageNumber->setName('currentPageNumber');
		$currentPageNumber->setValue(1);
		
		
		
		
		
		
		
		$this->add($currentPageNumber);
	}//function __construct() end
	
	
}
