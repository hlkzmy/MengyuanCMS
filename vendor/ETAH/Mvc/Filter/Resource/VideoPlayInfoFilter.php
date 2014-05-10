<?php
namespace Etah\Mvc\Filter\Resource;

use Etah\Mvc\Filter\BaseFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class VideoPlayInfoFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}