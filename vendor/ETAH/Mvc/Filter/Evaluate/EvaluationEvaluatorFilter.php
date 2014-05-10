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



class EvaluationEvaluatorFilter extends BaseFilter
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
		//1.新建教学评价的id相关的设置
		$id = new Input();
		$id->setName('id');
	
		$idNotEmpty = clone $empty;
		$idNotEmpty->setMessage("教学评价ID不能为空");
	
		$idDigits = clone $digits;
		$idDigits->setMessage('教学评价ID必须是数字',$idDigits::NOT_DIGITS);
		$idDigits->setMessage('教学评价ID未设置'   ,$idDigits::INVALID);
	
		$id->getValidatorChain()->addValidator($idNotEmpty);
		$id->getValidatorChain()->addValidator($idDigits);
		
		
		//2.新建教学评价参与人的验证
		$userId = new Input();
		$userId->setName('user_id');
		
		
		$inputFilter =  new InputFilter();
		$inputFilter->add($id);
		$inputFilter->add($userId);
		
		
		return $inputFilter;
	
	}//function getSubInputFilter() end
	
	
	
	
	
}