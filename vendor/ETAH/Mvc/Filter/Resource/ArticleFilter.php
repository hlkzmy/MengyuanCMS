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


class ArticleFilter extends BaseFilter
{
	
	function __construct(){
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$stripTags = new StripTags();
		
		
		//title 
		$StringLength = new StringLength();
		$StringLength->setMax('40');
		$StringLength->setMin('2');
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::INTEGER);
		$NoEmpty->setMessage("标题不能为空",'isEmpty');
		
		$StringLength->setMessage('标题不能超过 %max% 个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('标题不能小于 %min% 个字符',$StringLength::TOO_SHORT);
		
		$title = new Input();
		$title->setName('title');
		$title->getFilterChain()->attach($stripTags);
		$title->getValidatorChain()->addValidator($StringLength);
		$title->getValidatorChain()->addValidator($NoEmpty);
		
		$this->inputFilter->add($title);
		
		//sub_title
		$StringLength = new StringLength();
		$StringLength->setMax('40');
		$StringLength->setMin('2');
		$StringLength->setMessage('副标题不能超过 %max% 个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('副标题不能小于 %min% 个字符',$StringLength::TOO_SHORT);
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::INTEGER);
		$NoEmpty->setMessage("副标题不能为空",'isEmpty');
		
		$sub_title = new Input();
		$sub_title->setName('sub_title');
		$sub_title->getFilterChain()->attach($stripTags);
		$sub_title->getValidatorChain()->addValidator($StringLength);
		$sub_title->getValidatorChain()->addValidator($NoEmpty);
		$this->inputFilter->add($sub_title);
		
		//article_sort_id
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("请选择文章分类",'isEmpty');
		
		$article_sort_id = new Input();
		$article_sort_id->setName('article_sort_id');
		$article_sort_id->getValidatorChain()->addValidator($NoEmpty);
		
		
		$this->inputFilter->add($article_sort_id);
		
		
		//keyword
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::ALL);
		$NoEmpty->setMessage("文章关键字不能为空",'isEmpty');
		$keyword = new Input();
		$keyword->setName('keyword');
		$keyword->getValidatorChain()->addValidator($NoEmpty);
		$this->inputFilter->add($keyword);

		//content
		
		$StringLength = new StringLength();
		$StringLength->setMax('1000');
		$StringLength->setMin('10');
		$StringLength->setMessage('文章内容不能超过 %max% 个字符',$StringLength::TOO_LONG);
		$StringLength->setMessage('文章内容不能小于 %min% 个字符',$StringLength::TOO_SHORT);
		
		$NoEmpty  = new NotEmpty();
		$NoEmpty->setType(NotEmpty::INTEGER);
		$NoEmpty->setMessage("文章内容不能为空",'isEmpty');
		
		$content = new Input();
		$content->setName('content');
		$content->getFilterChain()->attach($stripTags);
		$content->getValidatorChain()->addValidator($StringLength);
		$content->getValidatorChain()->addValidator($NoEmpty);
		$this->inputFilter->add($content);
		
		return $this->inputFilter;
		
	}//function getSubInputFilter() end
	
	
	
	
	
}