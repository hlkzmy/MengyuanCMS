<?php
namespace Etah\Mvc\Filter\Resource;

use Etah\Mvc\Filter\BaseFilter;

use Zend\Validator\NotEmpty;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class CoursewareFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$empty = new NotEmpty();
		$empty->setType($empty::STRING);
		$empty->setMessage('请选择上传文件');
		
		$empty_name = new NotEmpty();
		$empty_name->setType($empty_name::STRING);
		$empty_name->setMessage('请填写课件名称');
		
		$courseware_name = $this->inputFilter->get('name');
		$courseware_name->getValidatorChain()->addValidator($empty_name);
		
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("课件分类不能为空",'isEmpty');
		
		$courseware_sort_id = new Input();
		$courseware_sort_id->setName('courseware_sort_id');
		$courseware_sort_id->getValidatorChain()->addValidator($NoEmpty);
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("请选择所属视频",'isEmpty');
		$video_id = new Input();
		$video_id->getValidatorChain()->addValidator($NoEmpty);
		$video_id->setName('video_id');
		
		
		$this->inputFilter->add($courseware_name);
		$this->inputFilter->add($courseware_sort_id);
		$this->inputFilter->add($video_id);
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}