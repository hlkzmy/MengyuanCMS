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


class UserFilter extends BaseFilter
{
	
	protected $Adapter;
	
	function __construct(Adapter $Adapter = NULL){
		
		$this->Adapter = $Adapter;
		
		parent::__construct();
		
	}
	
	public function setAdapter($Adapter)
	{
		$this->Adapter = $Adapter;	
	}
	

	public function getSubInputFilter()
	{
		$StripTags = new StripTags();
		
		$StringLength = new StringLength();
		$StringLength->setMax('16');
		$StringLength->setMin('2');
		
		$notEmpty = new NotEmpty();		
		$notEmpty->setType("string");
		$notEmpty->setMessage('用户名不能为空');
		
		$username = new Input();
		$username->setName('username');
		$username->getValidatorChain()->addValidator($notEmpty);
		
		if( $this->Adapter){
			
			$userIsExist = new \Zend\Validator\Db\NoRecordExists(array(
					'field'=>'username',
					'table'=>'information_user',
					'adapter'=>$this->Adapter,
			));
			$userIsExist->setMessage('您填写的用户名已经被注册');
			
			$username->getValidatorChain()->addValidator($userIsExist);
		
		}
		
		
		$realnameEmpty = new NotEmpty();
		$realnameEmpty->setType("string");
		$realnameEmpty->setMessage("真实姓名不能为空",'isEmpty');
		$realnameStringLength = clone $StringLength;
		$realnameStringLength->setMessage("你输入的真实姓名小于%min% 个字符",'stringLengthTooShort');
		$realnameStringLength->setMessage("你输入的真实姓名大于与 %max% 个字符",'stringLengthTooLong');
		$realname = new Input();
		$realname->setName('realname');
		$realname->getFilterChain()->attach($StripTags);
		$realname->getValidatorChain()->addValidator($realnameEmpty);
		$realname->getValidatorChain()->addValidator($realnameStringLength);
		
		
		$passwordEmpty = clone $notEmpty;
		$passwordEmpty->setMessage("密码不能为空",'isEmpty');
		$passwordStringLength = clone $StringLength;
		$passwordStringLength->setMin(6);
		$passwordStringLength->setMax(32);
		$passwordStringLength->setMessage("密码不能小于%min% 个字符",'stringLengthTooShort');
		$passwordStringLength->setMessage("密码不能大于 %max% 个字符",'stringLengthTooLong');
		
		$password = new Input();
		$password->setName('password');
		$password->setAllowEmpty(true);
		$password->getValidatorChain()->addValidator($passwordEmpty);
		$password->getValidatorChain()->addValidator($passwordStringLength);
		

		$confirmPassword = new Input();
		$confirmPassword->setName('confirm_password');
		$confirmPassword->getValidatorChain()->addValidator($passwordEmpty);
		$confirmPassword->getValidatorChain()->addValidator($passwordStringLength);
		
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("工号不能为空",'isEmpty');
		
		$job_number = new Input();
// 		$job_number->setAllowEmpty(true);
		$job_number->setName('job_number');
		$job_number->getFilterChain()->attach($StripTags);
		$job_number->getValidatorChain()->addValidator($NoEmpty);
		
		if( $this->Adapter){
				
			$job_numberIsExist = new \Zend\Validator\Db\NoRecordExists(array(
					'field'=>'job_number',
					'table'=>'information_user',
					'adapter'=>$this->Adapter,
			));
			$job_numberIsExist->setMessage('您填写的工号已存在');
				
			$job_number->getValidatorChain()->addValidator($job_numberIsExist);
		
		}
		
		
		$id_card_number = new Input();
		$id_card_number->setAllowEmpty(true);
		$id_card_number->setName('id_card');
		$id_card_number->getFilterChain()->attach($StripTags);

		if( $this->Adapter){
		
			$id_card_numberIsExist = new \Zend\Validator\Db\NoRecordExists(array(
					'field'=>'id_card',
					'table'=>'information_user',
					'adapter'=>$this->Adapter,
			));
			$id_card_numberIsExist->setMessage('该身份证号码已经被注册');
		
			$id_card_number->getValidatorChain()->addValidator($id_card_numberIsExist);
		
		}
		
		$telephoneRegex = new Regex(array('pattern' => '/\d+/'));
		$telephoneRegex->setMessage('你输入的手机号码不符合规范');
		$cellphone = new Input();
		$cellphone->setAllowEmpty(true);
		$cellphone->setName('cellphone');
		$cellphone->getValidatorChain()->addValidator($telephoneRegex);
		$cellphone->getFilterChain()->attach($StripTags);
		
		
		$qqRegex = new Regex(array('pattern' => '/\d+/'));
		$qqRegex->setMessage('你输入的QQ号码不符合规范');
		$qq = new Input();
		$qq->setAllowEmpty(true);
		$qq->setName('qq');
		$qq->getValidatorChain()->addValidator($qqRegex);
		$qq->getFilterChain()->attach($StripTags);
		
		
		$emailcheck = new EmailAddress();
		$emailcheck->setMessage('你输入的邮件不符合规范');
		$email = new Input();
		$email->setAllowEmpty(true);
		$email->setName('email');
		$email->getValidatorChain()->addValidator($emailcheck);
		$email->getFilterChain()->attach($StripTags);
		
		$schoolEmpty = clone $notEmpty;
		$schoolEmpty->setType($schoolEmpty::ALL);
		$schoolEmpty->setMessage("请选择所属学校");
		
		$school_id = new Input();
		$school_id->setName('school_id');
		$school_id->getValidatorChain()->addValidator($schoolEmpty);
		
		$work_type_id = new Input();
		$work_type_id->setName('work_type_id');
		$work_type_id->setAllowEmpty(true);
		

		$subject_id = new Input();
		$subject_id->setName('subject_id');
		$subject_id->setAllowEmpty(true);
		
		$notEmpty = new NotEmpty();
		$notEmpty->setType($notEmpty::ALL);
		$notEmpty->setMessage('个人简介不能为空');
		
		$description = new Input();
		$description->setName('description');
		$description->getValidatorChain()->addValidator($notEmpty);
		
		 
		$this->inputFilter->remove('description');
		$this->inputFilter->add($description);
		$this->inputFilter->add($school_id);
		$this->inputFilter->add($username);
		$this->inputFilter->add($realname);
		$this->inputFilter->add($password);
		$this->inputFilter->add($confirmPassword);
		$this->inputFilter->add($job_number);
		$this->inputFilter->add($id_card_number);
		$this->inputFilter->add($qq);
		$this->inputFilter->add($cellphone);
		$this->inputFilter->add($email);
		$this->inputFilter->add($work_type_id);
		$this->inputFilter->add($subject_id);
		
		
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}