<?php
namespace Etah\Mvc\Filter\Information;

use Etah\Mvc\Filter\BaseFilter;

use Zend\Validator\Regex;
use Zend\Validator\Digits;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\EmailAddress;

use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Db\Adapter\Adapter;


class SchoolFilter extends BaseFilter
{
	
	
	protected $Adapter;
	
	function __construct(Adapter $Adapter = NULL){
		
		$this->Adapter = $Adapter;
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		$stripTags = new StripTags();
		
		/*******************************************************************************/
		$not_empty_area_id = new NotEmpty();
		$not_empty_area_id->setType($not_empty_area_id::STRING);
		$not_empty_area_id->setMessage('请选择地域');
		
		$area_id = new Input();
		$area_id->setName('area_id');
		$area_id->getValidatorChain()->addValidator($not_empty_area_id);
		$area_id->getFilterChain()->attach($stripTags);
		
		$this->inputFilter->add($area_id);
		/*******************************************************************************/
		$not_empty_name = new NotEmpty();
		$not_empty_name->setType($not_empty_name::STRING);
		$not_empty_name->setMessage('请填写学校名称');
		
		$StringLength = new StringLength();
		$StringLength->setMax('20');
		$StringLength->setMin('2');
		$StringLength->setMessage('学校名称不能大于%max%个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('学校名称不能小于%min%个字符',$StringLength::TOO_SHORT);
		
		$name = new Input();
		$name->setName('name');
		$name->getFilterChain()->attach($stripTags);
		$name->getValidatorChain()->addValidator($StringLength);
		$name->getValidatorChain()->addValidator($not_empty_name);
		
		
		$this->inputFilter->add($name);
		/*******************************************************************************/
		
		$not_empty_school_sort_id = new NotEmpty();
		$not_empty_school_sort_id->setType($not_empty_school_sort_id::ALL);
		$not_empty_school_sort_id->setMessage('请选择学校类型');
		
		$school_sort_id = new Input();
		$school_sort_id->setName('school_sort_id');
		$school_sort_id->getValidatorChain()->addValidator($not_empty_school_sort_id);
		$school_sort_id->getFilterChain()->attach($stripTags);
		
		
		$this->inputFilter->add($school_sort_id);
		/*******************************************************************************/
		
		$not_empty_address = new NotEmpty();
		$not_empty_address->setType($not_empty_address::STRING);
		$not_empty_address->setMessage('请填写学校地址');
		
		$StringLength = new StringLength();
		$StringLength->setMax('50');
		$StringLength->setMin('2');
		$StringLength->setMessage('学校地址不能大于%max%个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('学校地址不能小于%min%个字符',$StringLength::TOO_SHORT);
		
		$address = new Input();
		$address->setName('address');
		$address->getFilterChain()->attach($stripTags);
		$address->getValidatorChain()->addValidator($StringLength);
		$address->getValidatorChain()->addValidator($not_empty_address);
		
		
		$this->inputFilter->add($address);
		/*******************************************************************************/
		
		$url = new Input();
		$url->setName('url');
		$url->getFilterChain()->attach($stripTags);
		$url->setAllowEmpty(true);
		
		
		
		
		$this->inputFilter->add($url);
		/*******************************************************************************/
		/*******************************************************************************/
		
		$not_empty_leader_realname = new NotEmpty();
		$not_empty_leader_realname->setType($not_empty_leader_realname::STRING);
		$not_empty_leader_realname->setMessage('请填写法人代表姓名');
		
		$StringLength = new StringLength();
		$StringLength->setMax('20');
		$StringLength->setMin('2');
		$StringLength->setMessage('法人代表姓名不能大于%max%个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('法人代表姓名不能小于%min%个字符',$StringLength::TOO_SHORT);
		
		$leader_realname = new Input();
		$leader_realname->setName('leader_realname');
		$leader_realname->getFilterChain()->attach($stripTags);
		$leader_realname->getValidatorChain()->addValidator($StringLength);
		$leader_realname->getValidatorChain()->addValidator($not_empty_leader_realname);

		
		
		
		$this->inputFilter->add($leader_realname);
		/*******************************************************************************/
		
		$not_empty_leader_cellphone = new NotEmpty();
		$not_empty_leader_cellphone->setType($not_empty_leader_cellphone::STRING);
		$not_empty_leader_cellphone->setMessage('请填写法人代表联系方式');
		
		$legal_leader_cellphone = new Digits();
		$legal_leader_cellphone->setMessage('您填写的联系方式不合法');
		
		$leader_cellphone = new Input();
		$leader_cellphone->setName('leader_cellphone');
		$leader_cellphone->getFilterChain()->attach($stripTags);
		$leader_cellphone->getValidatorChain()->addValidator($legal_leader_cellphone);
		$leader_cellphone->getValidatorChain()->addValidator($not_empty_leader_cellphone);
		
		
		$this->inputFilter->add($leader_cellphone);
		/*******************************************************************************/
		
		$StringLength = new StringLength();
		$StringLength->setMax('330');
		$StringLength->setMin('2');
		$StringLength->setMessage('学校简介不能大于%max%个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('学校简介不能小于%min%个字符',$StringLength::TOO_SHORT);
		
		$notEmpty = new NotEmpty();
		$notEmpty->setType($notEmpty::ALL);
		$notEmpty->setMessage('学校简介不能为空');
		
		$description = new Input();
		$description->setName('description');
		$description->getValidatorChain()->addValidator($StringLength);
		$description->getValidatorChain()->addValidator($notEmpty);
		
		$this->inputFilter->remove('description');
		$this->inputFilter->add($description);
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}