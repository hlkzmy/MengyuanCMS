<?php
namespace Etah\Mvc\Filter;


use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

//过滤
use Zend\Filter\StripTags;

//验证
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;


class BaseFilter implements InputFilterAwareInterface
{
	
	protected $inputFilter;
	
	public function __construct(){
		
		if (sizeof($this->inputFilter) < 1){
			$this->inputFilter = $this->getInputFilter();
		}
	}
	
	public function exchangeArray(){
	
		
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception('Not Used !');
	
	}
	
	public function getInputFilter()
	{
			
		$StripTags = new StripTags();
		//过滤用
		
		//id
		$Digits = new Digits();
		$Digits->setMessage('ID必须是数字',$Digits::NOT_DIGITS);
		
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("ID不能为空",'isEmpty');
		
		$id = new Input();
		$id->setName('id');
		
		$id->getFilterChain()->attach($StripTags);
		$id->getValidatorChain()->addValidator($Digits);
		$id->getValidatorChain()->addValidator($NoEmpty);
		
		
		
		//name
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("名称不能为空",'isEmpty');
		
		$StringLength = new StringLength();
		$StringLength->setMax('40');
		$StringLength->setMin('2');
		
		
		
		$StringLength->setMessage('名称不能超过 %max% 个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('名称不能小于 %min% 个字符',$StringLength::TOO_SHORT);
		
		$name = new Input();
		$name->setName('name');
		
		$name->getFilterChain()->attach($StripTags);
		$name->getValidatorChain()->addValidator($StringLength);
		$name->getValidatorChain()->addValidator($NoEmpty);
		
		
		
		//description
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("描述不能为空",'isEmpty');
		
		$StringLength = new StringLength();
		$StringLength->setMax('500');
		$StringLength->setMin('5');
		
		$StringLength->setMessage('描述不能超过 %max% 个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('描述不能小于 %min% 个字符',$StringLength::TOO_SHORT);
		
		$description = new Input();
		$description->setName('description');
		
		$description->getFilterChain()->attach($StripTags);
		$description->getValidatorChain()->addValidator($StringLength);
		$description->getValidatorChain()->addValidator($NoEmpty);
		
		
		
		$InputFilter = new InputFilter();
		$InputFilter->add($id);
		$InputFilter->add($name);
		$InputFilter->add($description);
		
		return $InputFilter;
	}
	
	
	public function complateInput($columns)
	{
		$rawValues = $this->inputFilter->getRawValues();
		
		
		$this->inputFilter->remove();
		
	}
	
	
}