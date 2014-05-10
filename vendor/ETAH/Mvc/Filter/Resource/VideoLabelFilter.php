<?php
namespace Etah\Mvc\Filter\Resource;

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


class VideoLabelFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$video_label_id = new Input();
		$video_label_id->setName('video_label_id');
		
		$this->inputFilter->add($video_label_id);
		
		return $this->inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}