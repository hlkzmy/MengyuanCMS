<?php
namespace Etah\Mvc\Filter\common;

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


class InteractClassroomFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		//-----------------------------新建字符串一系列的过滤条件-----------------------------//
		//1.新建字符串转小写对象
		$stringToLower = new StringToLower();
		
		//2.新建字符串过滤html标签对象
		$stripTags = new StripTags();
		
		//3.新建字符串过滤空白字符对象
		$stringTrim = new StringTrim();
		
		
		//-----------------------------新建字符串一系列的验证条件-----------------------------//
		//1.新建字符串长度对象
		$stringLength =  new StringLength();
		
		//2.新建是否为空的验证
		$empty = new NotEmpty();
		
		//3.新建数字的相关相关认证
		$digits = new Digits();
		
		//-----------------------------新建输入对象--------------------------------------//
		//1.新建id的验证
		$id = new Input();
		$id->setName('id');
		
		$idNotEmpty = clone $empty;
		$idNotEmpty->setMessage("id不能为空");
		
		$idDigits = clone $digits;
		$idDigits->setMessage('id必须是数字',$idDigits::NOT_DIGITS);
		$idDigits->setMessage('教室的id未设置',$idDigits::INVALID);
		
		$id->getValidatorChain()->addValidator($idNotEmpty);
		$id->getValidatorChain()->addValidator($idDigits);
		
		$name = new Input();
		$name->setName('classroom_name');
		$name->getFilterChain()->attach($stringToLower);
		$name->getFilterChain()->attach($stripTags);
		$name->getFilterChain()->attach($stringTrim);
		
		$nameStringLength = clone $stringLength;
		$nameStringLength->setMax(5);
		$nameStringLength->setMax(40);
		$nameStringLength->setMessage('教室的名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$nameStringLength->setMessage('教室的名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		$nameStringLength->setMessage('教室的名称长度非法',$stringLength::INVALID);
		
		$nameEmpty = clone $empty;
		$nameEmpty->setMessage('教室的名称不能为空');
		
		$name->getValidatorChain()->addValidator($nameEmpty);
		$name->getValidatorChain()->addValidator($nameStringLength);
		
		
		$description = new Input();
		$description->setName('description');
		$description->getFilterChain()->attach($stringToLower);
		$description->getFilterChain()->attach($stripTags);
		$description->getFilterChain()->attach($stringTrim);
		
		$descriptionStringLength = clone $stringLength;
		$descriptionStringLength->setMax(5);
		$descriptionStringLength->setMax(100);
		$descriptionStringLength->setMessage('描述信息的内容不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$descriptionStringLength->setMessage('描述信息的内容不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		$descriptionEmpty = clone $empty;
		$descriptionEmpty->setMessage('交互教室的描述不能为空');
		$description->getValidatorChain()->addValidator($descriptionStringLength);
		$description->getValidatorChain()->addValidator($descriptionEmpty);
		
		$listener_classroom = new Input();
		$listener_classroom->setName('listener_classroom');
		
		
		$start_time = new Input();
		$start_time->setName('start_time');
		
		$end_time = new Input();
		$end_time->setName('end_time');		
		
		$video_name = new Input();
		$video_name->setName('video_name');
		
		
		$inputFilter =  new InputFilter();
		
		
		$inputFilter->add($id);
		$inputFilter->add($name);
		$inputFilter->add($description);
		$inputFilter->add($listener_classroom);
		$inputFilter->add($start_time);
		$inputFilter->add($end_time);
		$inputFilter->add($video_name);
		
		return $inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}