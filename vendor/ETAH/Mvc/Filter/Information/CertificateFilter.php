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


class CertificateFilter extends BaseFilter
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
		
		$not_empty = new NotEmpty();
		$not_empty->setType($not_empty::STRING);
		$not_empty->setMessage('请填写法人代表联系方式');
		
		
		$name = $this->inputFilter->get('name');
		$name->setErrorMessage('证书名称不能小于2个字符或者大于40个字符');
		
		$user_id = clone $this->inputFilter->get('id');
		$user_id->setName('user_id');
		$user_id->setErrorMessage('用户选择错误');
		
		$this->inputFilter->add($user_id);
		/*******************************************************************************/
		
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}