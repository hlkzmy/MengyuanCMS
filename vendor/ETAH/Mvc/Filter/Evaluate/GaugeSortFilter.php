<?php
namespace Etah\Mvc\Filter\Evaluate;

use Zend\Validator\Digits;

use Zend\Validator\StringLength;

use Zend\Validator\NotEmpty;

use Etah\Mvc\Filter\BaseFilter;


use Zend\Filter\StringTrim;
use Zend\Filter\StringToLower;
use Zend\Filter\StripTags;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;






class GaugeSortFilter extends BaseFilter
{
	
	function __construct(){
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("请选择父级分类",'isEmpty');
		
		$parent_id = new Input();
		$parent_id->setName('parent_id');
		$parent_id->getValidatorChain()->addValidator($NoEmpty);
		$this->inputFilter->add($parent_id);
		
		
		return $this->inputFilter;
	}
	
}