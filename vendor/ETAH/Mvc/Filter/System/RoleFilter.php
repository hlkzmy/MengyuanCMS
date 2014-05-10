<?php
namespace Etah\Mvc\Filter\System;

use Etah\Mvc\Filter\BaseFilter;

use Zend\Validator\Regex;
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;

use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class RoleFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		
		$parent_id = clone $this->inputFilter->get('id');
		$parent_id->setName('parent_id');
		
		
		$this->inputFilter->add($parent_id);
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}