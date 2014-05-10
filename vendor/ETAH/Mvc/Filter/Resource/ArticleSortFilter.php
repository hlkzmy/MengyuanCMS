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


class ArticleSortFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("父级分类不能为空",'isEmpty');
		
		$parent_id = new Input();
		$parent_id->setName('parent_id');
		$this->inputFilter->add($parent_id);
		$parent_id->getValidatorChain()->addValidator($NoEmpty);
		
		return $this->inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}