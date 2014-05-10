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


class ArticleContentFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$stripTags = new StripTags();
		
		
		$content = new Input();
		$content->setName('content');
		$this->inputFilter->add($content);
		
		return $this->inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}