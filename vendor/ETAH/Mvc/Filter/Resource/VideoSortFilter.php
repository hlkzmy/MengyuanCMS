<?php
namespace Etah\Mvc\Filter\Resource;

use Etah\Mvc\Filter\BaseFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StringToLower;
use Zend\Filter\StripTags;

use Zend\Validator\Regex;
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;


use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class VideoSortFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$NotEmpty = new NotEmpty();
		$NotEmpty->setType($NotEmpty::ALL);
		$NotEmpty->setMessage('请选择父级分类');
		
		$parent_id = new Input();
		$parent_id->setName('parent_id');
		$parent_id->getValidatorChain()->addValidator($NotEmpty);
		
		$this->inputFilter->add($parent_id);
		return $this->inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}