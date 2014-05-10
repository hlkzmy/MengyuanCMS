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


class UserRoleFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$notEmpty = new NotEmpty();
		$notEmpty->setType($notEmpty::ALL);
		$notEmpty->setMessage('请为该用户选择一个角色');
		
		$role_id = new Input();
		$role_id->setName('role_id');
		$role_id->getValidatorChain()->addValidator($notEmpty);
		
		
		$this->inputFilter->add($role_id);
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}