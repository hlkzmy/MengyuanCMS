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



class NavigationFilter extends BaseFilter
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
		
		
		//3.
		$digits = new Digits();
		
		//-----------------------------新建输入对象--------------------------------------//
		//1.新建页面id的验证
		$id = new Input();
		$id->setName('id');
		
		
		$idNotEmpty = clone $empty;
		$idNotEmpty->setMessage("id不能为空");
		
		$idDigits = clone $digits;
		$idDigits->setMessage('id必须是数字',$idDigits::NOT_DIGITS);
		$idDigits->setMessage('在编辑页面中未设置页面的id',$idDigits::INVALID);
		
		$id->getValidatorChain()->addValidator($idNotEmpty);
		$id->getValidatorChain()->addValidator($idDigits);
		
		//2.新建页面parent_id的验证
		$parentId = new Input();
		$parentId->setName('parent_id');
		
		$parentIdNotEmpty = clone $empty;
		$parentIdNotEmpty->setMessage("导航栏项目的父节点parent_id不能为空");
		
		$parentIdDigits = clone $digits;
		$parentIdDigits->setMessage('导航栏项目的父节点parent_id为非法',$idDigits::NOT_DIGITS);
		$parentIdDigits->setMessage('导航栏项目的父节点parent_id未设置',$idDigits::INVALID);
		$parentIdDigits->setMessage('导航栏项目的父节点parent_id未设置',$idDigits::STRING_EMPTY);
		
		$parentId->getValidatorChain()->addValidator($parentIdDigits);
		$parentId->getValidatorChain()->addValidator($parentIdNotEmpty);
		
		
		//3.新建页面名称输入对象
		$name = new Input();
		$name->setName('name');
		$name->getFilterChain()->attach($stringToLower);
		$name->getFilterChain()->attach($stripTags);
		$name->getFilterChain()->attach($stringTrim);
		
		
		$nameStringLength = clone $stringLength;
		$nameStringLength->setMax(5);
		$nameStringLength->setMax(20);
		$nameStringLength->setMessage('导航栏项目名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$nameStringLength->setMessage('导航栏项目名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		$nameStringLength->setMessage('asdas',$stringLength::INVALID);
		
		$nameEmpty = clone $empty;
		$nameEmpty->setMessage('导航栏项目名称不能为空');
		
		$name->getValidatorChain()->addValidator($nameEmpty);
		$name->getValidatorChain()->addValidator($nameStringLength);
		
		//4.新建命名空间输入对象
		$namespace = new Input();
		$namespace->setName('namespace');
		$namespace->getFilterChain()->attach($stringToLower);
		$namespace->getFilterChain()->attach($stripTags);
		$namespace->getFilterChain()->attach($stringTrim);
		
		$namespaceStringLength = clone $stringLength;
		$namespaceStringLength->setMax(5);
		$namespaceStringLength->setMax(20);
		$namespaceStringLength->setMessage('命名空间名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$namespaceStringLength->setMessage('命名空间名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		
		$namespaceEmpty = clone $empty;
		$namespaceEmpty->setMessage('命名空间名称不能为空');
		
		$namespace->getValidatorChain()->addValidator($namespaceEmpty);
		$namespace->getValidatorChain()->addValidator($namespaceStringLength);
		
		//5.新建控制器输入对象
		$controller = new Input();
		$controller->setName('controller');
		$controller->getFilterChain()->attach($stringToLower);
		$controller->getFilterChain()->attach($stripTags);
		$controller->getFilterChain()->attach($stringTrim);
		
		$controllerStringLength = clone $stringLength;
		$controllerStringLength->setMax(5);
		$controllerStringLength->setMax(20);
		$controllerStringLength->setMessage('控制器名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$controllerStringLength->setMessage('控制器名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		
		
		$controllerEmpty = clone $empty;
		$controllerEmpty->setMessage('控制器名称不能为空');
		
		$controller->getValidatorChain()->addValidator($controllerEmpty);
		$controller->getValidatorChain()->addValidator($controllerStringLength);
		
		//6.新建方法名称输入对象
		$action = new Input();
		$action->setName('action');
		$action->getFilterChain()->attach($stringToLower);
		$action->getFilterChain()->attach($stripTags);
		$action->getFilterChain()->attach($stringTrim);
		
		$actionStringLength = clone $stringLength;
		$actionStringLength->setMax(5);
		$actionStringLength->setMax(20);
		$actionStringLength->setMessage('方法名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$actionStringLength->setMessage('方法名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		
		$actionEmpty = clone $empty;
		$actionEmpty->setMessage('方法名称不能为空');
		
		$action->getValidatorChain()->addValidator($actionEmpty);
		$action->getValidatorChain()->addValidator($actionStringLength);
		
		//7.新建描述性信息输入对象
 		
		$parameter = new Input();
		$parameter->setName('parameter');
		$parameter->setAllowEmpty(true);

		
		
		//8.新建描述性信息输入对象
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
		
		
		
		
		$inputFilter =  new InputFilter();
		$inputFilter->add($id);
		$inputFilter->add($parentId);
		$inputFilter->add($name);
		$inputFilter->add($namespace);
		$inputFilter->add($controller);
		$inputFilter->add($action);
		$inputFilter->add($parameter);
		$inputFilter->add($description);
		
		return $inputFilter;
		
	}
	
	
	
	
	
}