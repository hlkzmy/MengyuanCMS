<?php
namespace Etah\Mvc\Filter\Resource;

use Etah\Mvc\Filter\BaseFilter;

use Zend\Validator\NotEmpty;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class VideoFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$empty = new NotEmpty();
		$empty->setType($empty::STRING);
		$empty->setMessage('请先上传视频文件');
		
		
		$video_sort_id_empty = new NotEmpty();
		$video_sort_id_empty->setType('all');
		$video_sort_id_empty->setMessage('视频分类id不能为空');
		
		$video_sort_id = new Input();
		$video_sort_id->setName('video_sort_id');
		$video_sort_id->getValidatorChain()->addValidator($video_sort_id_empty);
		
		$upload_flag = new Input();
		$upload_flag->setName('upload_flag');
		$upload_flag->getValidatorChain()->addValidator($empty);
		
		$speaker = new Input();
		$speaker->setName('speaker');
		
		$school_id = clone $this->inputFilter->get('id');
		$school_id->setName('school_id');
		
		$userId = new Input();
		$userId->setName('user_id');
		
		
		$this->inputFilter->add($video_sort_id);
		$this->inputFilter->add($upload_flag);
		$this->inputFilter->add($speaker);
		$this->inputFilter->add($school_id);
		$this->inputFilter->add($userId);
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}