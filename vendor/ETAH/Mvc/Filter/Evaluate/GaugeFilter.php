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






class GaugeFilter extends BaseFilter
{
	
	function __construct(){
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		//过滤html标签
		$stripTags = new StripTags();
		
		
//-----------------------------------------------------------------------------------------//		
		$id = new Input();
		$id->setName('id');
		$id->getFilterChain()->attach($stripTags);
		
//-----------------------------------------------------------------------------------------//

		$nameEmpty = new NotEmpty();
		$nameEmpty->setType($nameEmpty::STRING);
		$nameEmpty->setMessage('量规表名称不能为空');
		
		$nameStringLength = new StringLength();
		$nameStringLength->setMax('20');
		$nameStringLength->setMin('2');
		$nameStringLength->setMessage('量规表名称不能小于%min%个字符',$nameStringLength::TOO_SHORT);
		$nameStringLength->setMessage('量规表名称不能大于%max%个字符',$nameStringLength::TOO_LONG);
		
		$name = new Input();
		$name->setName('name');
		$name->getValidatorChain()->addValidator($nameStringLength);
		$name->getValidatorChain()->addValidator($nameEmpty);
		$name->getFilterChain()->attach($stripTags);
		
//-----------------------------------------------------------------------------------------//		
		

		$gaugeSortId = new Input();
		$gaugeSortId->setName('gauge_sort_id');
		
		$gaugeSortIdNotEmpty = new NotEmpty();
		$gaugeSortIdNotEmpty->setMessage("请选择量规表所属的分类");
		
		$gaugeSortIdDigits = new Digits();
		$gaugeSortIdDigits->setMessage('量规表所属的分类id为非法',$gaugeSortIdDigits::NOT_DIGITS);
		$gaugeSortIdDigits->setMessage('量规表所属的分类id未设置',$gaugeSortIdDigits::INVALID);
		
		
		$gaugeSortId->getValidatorChain()->addValidator($gaugeSortIdDigits);
		$gaugeSortId->getValidatorChain()->addValidator($gaugeSortIdNotEmpty);
		
		
		
		$inputFilter = $this->inputFilter;
		
		$inputFilter->add($id);
		$inputFilter->add($name);
		$inputFilter->add($gaugeSortId);
		
		return $inputFilter;
	}
	
}