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



class EvaluationFilter extends BaseFilter
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
		//1.新建教学评价的id相关的设置
		$id = new Input();
		$id->setName('id');
	
		$idNotEmpty = clone $empty;
		$idNotEmpty->setMessage("id不能为空");
	
		$idDigits = clone $digits;
		$idDigits->setMessage('id必须是数字'	 ,$idDigits::NOT_DIGITS);
		$idDigits->setMessage('布局容器的id未设置',$idDigits::INVALID);
	
		$id->getValidatorChain()->addValidator($idNotEmpty);
		$id->getValidatorChain()->addValidator($idDigits);
		
		//2.新建教学评价的name的相关设置
		$name = new Input();
		$name->setName('name');
		$name->getFilterChain()->attach($stringToLower);
		$name->getFilterChain()->attach($stripTags);
		$name->getFilterChain()->attach($stringTrim);
		
		$nameStringLength = clone $stringLength;
		$nameStringLength->setMax(5);
		$nameStringLength->setMax(40);
		$nameStringLength->setMessage('教学评价的名称不能超过 %max% 个字符',$stringLength::TOO_LONG);
		$nameStringLength->setMessage('教学评价的名称不能小于 %min% 个字符',$stringLength::TOO_SHORT);
		$nameStringLength->setMessage('教学评价的名称长度非法',$stringLength::INVALID);
		
		$nameEmpty = clone $empty;
		$nameEmpty->setMessage('教学评价的名称不能为空');
		
		$name->getValidatorChain()->addValidator($nameEmpty);
		$name->getValidatorChain()->addValidator($nameStringLength);
		
		//3.新建教学评价的id相关的设置
		$evaluationSortId = new Input();
		$evaluationSortId->setName('evaluation_sort_id');
	
		$evaluationSortIdNotEmpty = clone $empty;
		$evaluationSortIdNotEmpty->setMessage("请选择教学评价所属的分类");
	
		$evaluationSortIdDigits = clone $digits;
		$evaluationSortIdDigits->setMessage('教学评价所属的分类id为非法',$evaluationSortIdDigits::NOT_DIGITS);
		$evaluationSortIdDigits->setMessage('教学评价所属的分类id未设置',$evaluationSortIdDigits::INVALID);
	
		$evaluationSortId->getValidatorChain()->addValidator($evaluationSortIdDigits);
		$evaluationSortId->getValidatorChain()->addValidator($evaluationSortIdNotEmpty);

	
		//4.新建教学评价的添加人的id
		$addUserId = new Input();
		$addUserId->setName('add_user_id');
	
		//5.新建教学评价的被评价人的id
		$evaluatedUserId = new Input();
		$evaluatedUserId->setName('evaluated_user_id');
		
		//6.新建教学评价的类型，是直播评价 还是 录播评价
		$type = new Input();
		$type->setName('type');
		
		//7.新建教学评价的所属的学校
		$schoolId = new Input();
		$schoolId->setName('school_id');
		
		$schoolIdNotEmpty = new NotEmpty();
		$schoolIdNotEmpty->setMessage('教学评价所属的学校不能为空');
		$schoolId->getValidatorChain()->addValidator($schoolIdNotEmpty);
		
		//8.新建教学评价的所属的教室
		$classroomid = new Input();
		$classroomid->setName('stream_list');
		
		$classroomidNotEmpty = new NotEmpty();
		$classroomidNotEmpty->setMessage('教学评价的流不能为空');
		
		$classroomid->getValidatorChain()->addValidator($classroomidNotEmpty);
	
		
		//9.教学评价开始的时间
		$startTime = new Input();
		$startTime->setName('start_time');
		
		$startTimeNotEmpty = new NotEmpty();
		$startTimeNotEmpty->setMessage('教学评价开始时间不能为空');
		
		$startTime->getValidatorChain()->addValidator($startTimeNotEmpty);
		
		//10.教学评价结束的时间
		$endTime = new Input();
		$endTime->setName('end_time');

		$endTimeNotEmpty = new NotEmpty();
		$endTimeNotEmpty->setMessage('教学评价结束时间不能为空');
		
		$endTime->getValidatorChain()->addValidator($endTimeNotEmpty);
		//11.教学评价所绑定的量规表
		
		$notempty = new NotEmpty();
		$notempty->setType($notempty::ALL);
		$notempty->setMessage('请正确选择量规表');
		$gaugeId = new Input();
		$gaugeId->setName('gauge_id');
		$gaugeId->getValidatorChain()->addValidator($notempty);
		
		//12.教学评价的课程描述
		$notempty = new NotEmpty();
		$notempty->setType($notempty::STRING);
		$notempty->setMessage('教学评价课程描述不能为空');
		$courseDescription = new Input();
		$courseDescription->setName('course_description');
		$courseDescription->getValidatorChain()->addValidator($notempty);
		
		
		//13.教学评价的课程描述
		$notempty = new NotEmpty();
		$notempty->setType($notempty::STRING);
		$notempty->setMessage('教学评价目的不能为空');
		$teachPurpose = new Input();
		$teachPurpose->setName('teach_purpose');
		$teachPurpose->getValidatorChain()->addValidator($notempty);
		
		//14.教学评价所设定的年级
		$notempty = new NotEmpty();
		$notempty->setType($notempty::ALL);
		$notempty->setMessage('请正确选择年级');
		$gradeId = new Input();
		$gradeId->setName('grade_id');
		$gradeId->getValidatorChain()->addValidator($notempty);
		//15.教学评价所设定的科目
		$notempty = new NotEmpty();
		$notempty->setType($notempty::ALL);
		$notempty->setMessage('请正确选择主讲科目');
		$subjectId = new Input();
		$subjectId->setName('subject_id');
		$subjectId->getValidatorChain()->addValidator($notempty);
		//16.教学评价所绑定的视频ID
		$videoId = new Input();
		$videoId->setName('video_id');
		
		//17.教学评价所绑定的教学评比的ID
		$competitionId = new Input();
		$competitionId->setName('competition_id');
		
		//18.教学评价的录制状态,一个视频处在录制状态，那么发送录制命令的时候就不会出现在录制列表中
		$recordStatus = new Input();
		$recordStatus->setName('record_status');
		
		//19.教学评价的状态
		$status = new Input();
		$status->setName('status');
		
		
		$inputFilter =  new InputFilter();
		$inputFilter->add($id);
		$inputFilter->add($name);
		$inputFilter->add($addUserId);
		$inputFilter->add($evaluationSortId);
		$inputFilter->add($evaluatedUserId);
		$inputFilter->add($type);
		$inputFilter->add($schoolId);
		$inputFilter->add($classroomid);
		$inputFilter->add($startTime);
		$inputFilter->add($endTime);
		$inputFilter->add($gaugeId);
		$inputFilter->add($courseDescription);
		$inputFilter->add($teachPurpose);
		$inputFilter->add($gradeId);
		$inputFilter->add($subjectId);
		$inputFilter->add($videoId);
		$inputFilter->add($competitionId);
		$inputFilter->add($recordStatus);
		$inputFilter->add($status);
		
		return $inputFilter;
	
	}//function getSubInputFilter() end
	
	
	
	
	
}