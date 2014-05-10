<?php
namespace Etah\Mvc\Filter\Website;

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


class ContainerFilter extends BaseFilter
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
		$idDigits->setMessage('布局容器的id未设置',$idDigits::INVALID);
		
		$id->getValidatorChain()->addValidator($idNotEmpty);
		$id->getValidatorChain()->addValidator($idDigits);
		
		//2.新建页面page_id的验证
		$pageId = new Input();
		$pageId->setName('page_id');
		
		$pageIdNotEmpty = clone $empty;
		$pageIdNotEmpty->setMessage("布局容器所在页面的page_id不能为空");
		
		$pageIdDigits = clone $digits;
		$pageIdDigits->setMessage('布局容器所在页面的page_id为非法',$idDigits::NOT_DIGITS);
		$pageIdDigits->setMessage('布局容器所在页面的page_id未设置',$idDigits::INVALID);
		
		$pageId->getValidatorChain()->addValidator($pageIdNotEmpty);
		$pageId->getValidatorChain()->addValidator($pageIdDigits);
		
		//3.新建页面parent_id的验证
		$parentId = new Input();
		$parentId->setName('parent_id');
		
		$parentIdNotEmpty = clone $empty;
		$parentIdNotEmpty->setMessage("布局容器的父节点parent_id不能为空");
		
		$parentIdDigits = clone $digits;
		$parentIdDigits->setMessage('布局容器的父节点parent_id为非法',$idDigits::NOT_DIGITS);
		$parentIdDigits->setMessage('布局容器的父节点parent_id未设置',$idDigits::INVALID);
		$parentIdDigits->setMessage('布局容器的父节点parent_id未设置',$idDigits::STRING_EMPTY);
		
		$parentId->getValidatorChain()->addValidator($parentIdDigits);
		$parentId->getValidatorChain()->addValidator($parentIdNotEmpty);
		
		//4.新建布局容器英文名称输入对象
		$name = new Input();
		$name->setName('name');
		$name->getFilterChain()->attach($stringToLower);
		$name->getFilterChain()->attach($stripTags);
		$name->getFilterChain()->attach($stringTrim);
		
		$nameStringLength = clone $stringLength;
		$nameStringLength->setMax(5);
		$nameStringLength->setMax(40);
		$nameStringLength->setMessage('布局容器英文名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$nameStringLength->setMessage('布局容器英文名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		$nameStringLength->setMessage('布局容器英文名称长度非法',$stringLength::INVALID);
		
		$nameEmpty = clone $empty;
		$nameEmpty->setMessage('布局容器英文名称名称不能为空');
		
		$name->getValidatorChain()->addValidator($nameEmpty);
		$name->getValidatorChain()->addValidator($nameStringLength);
		
		//5.新建布局容器中文名称输入对象
		$title = new Input();
		$title->setName('title');
		$title->getFilterChain()->attach($stringToLower);
		$title->getFilterChain()->attach($stripTags);
		$title->getFilterChain()->attach($stringTrim);
		
		$titleStringLength = clone $stringLength;
		$titleStringLength->setMax(5);
		$titleStringLength->setMax(40);
		$titleStringLength->setMessage('布局容器中文名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$titleStringLength->setMessage('布局容器中文名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		$titleStringLength->setMessage('布局容器中文名称长度非法',$stringLength::INVALID);
		
		$titleEmpty = clone $empty;
		$titleEmpty->setMessage('布局容器中文名称不能为空');
		
		$title->getValidatorChain()->addValidator($titleEmpty);
		$title->getValidatorChain()->addValidator($titleStringLength);
		
		//6.新建布局容器描述性信息输入对象
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
		$descriptionEmpty->setMessage('描述信息的内容不能为空');
		
		$description->getValidatorChain()->addValidator($descriptionEmpty);
		$description->getValidatorChain()->addValidator($descriptionStringLength);
		
		
		//7.新建布局容器CSS属性的过滤对象
		$css = new Input();
		$css->setName('css');
		
		
		$inputFilter =  new InputFilter();
		$inputFilter->add($id);
		$inputFilter->add($parentId);
		$inputFilter->add($pageId);
		$inputFilter->add($name);
		$inputFilter->add($title);
		$inputFilter->add($description);
		$inputFilter->add($css);
		
		return $inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}