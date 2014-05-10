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


class LiveClassroomFilter extends BaseFilter
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
		
		//2.新建页面server_id的验证
		$serverId = new Input();
		$serverId->setName('server_id');
		
		$serverIdNotEmpty = clone $empty;
		$serverIdNotEmpty->setMessage("教室所在录播服务器的server_id不能为空");
		
		$serverIdDigits = clone $digits;
		$serverIdDigits->setMessage('教室所在录播服务器的server_id为非法',$idDigits::NOT_DIGITS);
		$serverIdDigits->setMessage('教室所在录播服务器的server_id未设置',$idDigits::INVALID);
		
		$serverId->getValidatorChain()->addValidator($serverIdNotEmpty);
		$serverId->getValidatorChain()->addValidator($serverIdDigits);
		
		//3.新建页面school_id的验证
		$schoolId = new Input();
		$schoolId->setName('school_id');
		
		$schoolIdNotEmpty = clone $empty;
		$schoolIdNotEmpty->setMessage("教室所在学校的school_id不能为空");
		
		$schoolIdDigits = clone $digits;
		$schoolIdDigits->setMessage('教室所在学校的school_id为非法',$idDigits::NOT_DIGITS);
		$schoolIdDigits->setMessage('教室所在学校的school_id未设置',$idDigits::INVALID);
		$schoolIdDigits->setMessage('教室所在学校的school_id未设置',$idDigits::STRING_EMPTY);
		
		$schoolId->getValidatorChain()->addValidator($schoolIdDigits);
		$schoolId->getValidatorChain()->addValidator($schoolIdNotEmpty);
		
		//4.新建布局容器英文名称输入对象
		$name = new Input();
		$name->setName('live_classroom_name');
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
		$nameEmpty->setMessage('教室的名称名称不能为空');
		
		$name->getValidatorChain()->addValidator($nameEmpty);
		$name->getValidatorChain()->addValidator($nameStringLength);
		
		//5.新建布局容器描述性信息输入对象
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
		
		//6.新建流对象
		
		
		$classroom_id = new Input();
		$classroom_id->setName('classroom_id');
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("主讲教师不能为空",'isEmpty');
		
		$teacher_id = new Input();
		$teacher_id->setName('teacher_id');
		$teacher_id->getValidatorChain()->addValidator($NoEmpty);
		
		$province_id = new Input();
		$province_id->setName('province_id');
		
		$city_id = new Input();
		$city_id->setName('city_id');
		
		$district_id = new Input();
		$district_id->setName('district_id');
		
		$subject_id = new Input();
		$subject_id->setName('subject_id');
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("开始时间不能为空",'isEmpty');
		
		$start_time = new Input();
		$start_time->setName('start_time');
		$start_time->getValidatorChain()->addValidator($NoEmpty);
		
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("结束时间不能为空",'isEmpty');
		
		$end_time = new Input();
		$end_time->setName('end_time');		
		$end_time->getValidatorChain()->addValidator($NoEmpty);
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("课程名称不能为空",'isEmpty');
		
		$video_name = new Input();
		$video_name->setName('video_name');
		$video_name->getValidatorChain()->addValidator($NoEmpty);
		
		
		$inputFilter =  new InputFilter();
		$inputFilter->add($id);
		$inputFilter->add($serverId);
		$inputFilter->add($schoolId);
		$inputFilter->add($classroom_id);
		$inputFilter->add($name);
		$inputFilter->add($description);
		$inputFilter->add($teacher_id);
		$inputFilter->add($province_id);
		$inputFilter->add($city_id);
		$inputFilter->add($district_id);
		$inputFilter->add($subject_id);
		$inputFilter->add($start_time);
		$inputFilter->add($end_time);
		$inputFilter->add($video_name);
		
		return $inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}