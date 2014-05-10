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
use Zend\Db\Adapter\Adapter;


class AreaFilter extends BaseFilter
{
	
	
	protected $Adapter;
	
	function __construct(Adapter $Adapter = NULL){
		
		$this->Adapter = $Adapter;
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		$stripTags = new StripTags();
		
		/*******************************************************************************/
		$not_empty_parent_id = new NotEmpty();
		$not_empty_parent_id->setType($not_empty_parent_id::STRING);
		$not_empty_parent_id->setMessage('请选择地域');
		
		$parent_id = new Input();
		$parent_id->setName('parent_id');
		$parent_id->getValidatorChain()->addValidator($not_empty_parent_id);
		$parent_id->getFilterChain()->attach($stripTags);
		
		$this->inputFilter->add($parent_id);
		
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}