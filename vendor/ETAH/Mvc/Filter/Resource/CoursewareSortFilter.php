<?php
namespace Etah\Mvc\Filter\Resource;

use Zend\Validator\NotEmpty;

use Etah\Mvc\Filter\BaseFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class CoursewareSortFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("父级分类不能为空",'isEmpty');
		
		$parent_id = new Input();
		$parent_id->setName('parent_id');
		$parent_id->getValidatorChain()->addValidator($NoEmpty);
		
		$this->inputFilter->add($parent_id);
		
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}