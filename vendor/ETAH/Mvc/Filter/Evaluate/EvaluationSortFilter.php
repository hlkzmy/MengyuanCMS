<?php
namespace Etah\Mvc\Filter\Evaluate;

use Etah\Mvc\Filter\BaseFilter;
use Zend\Filter\StringTrim;
use Zend\Filter\StringToLower;
use Zend\Filter\StripTags;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

use Zend\Validator\Regex;
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;



class EvaluationSortFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
		
	}
	
	public function getSubInputFilter()
	{
		//-----------------------------新建字符串一系列的验证条件-----------------------------//
		
		//1.新建是否为空的验证
		$empty = new NotEmpty();
	
		//3.新建数字的相关相关认证
		$digits = new Digits();
	
		//-----------------------------新建输入对象--------------------------------------//
		$id = new Input();
		$id->setName('id');
	
		$idNotEmpty = clone $empty;
		$idNotEmpty->setMessage("教学评价分类ID不能为空");
	
		$idDigits = clone $digits;
		$idDigits->setMessage('教学评价分类ID必须是数字',$idDigits::NOT_DIGITS);
		$idDigits->setMessage('教学评价分类ID未设置'   ,$idDigits::INVALID);
	
		$id->getValidatorChain()->addValidator($idDigits);
		$id->getValidatorChain()->addValidator($idNotEmpty);
		
		
		
		
		$nameNotEmpty = clone $empty;
		$nameNotEmpty->setMessage('教学评价分类的名称不能为空');
		
		$name = new Input();
		$name->setName('name');
		$name->getValidatorChain()->addValidator($nameNotEmpty);
		
		$descriptionNotEmpty = clone $empty;
		$descriptionNotEmpty->setMessage('教学评价的描述不能为空');
		
		$description = new Input();
		$description->setName('description');
		$description->getValidatorChain()->addValidator($descriptionNotEmpty);
		$description->getValidatorChain()->addValidator($descriptionNotEmpty);
		
		
		$inputFilter =  $this->inputFilter;
		$inputFilter->add($id);
		$inputFilter->add($name);
		$inputFilter->add($description);
		
		
		return $inputFilter;
	
	}//function getSubInputFilter() end
	
	
	
	
	
}