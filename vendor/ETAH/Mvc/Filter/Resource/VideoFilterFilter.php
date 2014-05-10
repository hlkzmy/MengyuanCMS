<?php
namespace Etah\Mvc\Filter\Resource;

use Etah\Mvc\Filter\BaseFilter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;


class VideoFilterFilter extends BaseFilter
{
	
	
	
	function __construct(){
		
		
		parent::__construct();
		
	}
	

	public function getSubInputFilter()
	{
		
		$year = new Input();
		$year->setName('year');
		$year->setAllowEmpty(true);
		
		$country_id = clone $this->inputFilter->get('id');
		$country_id->setName('country_id');
		
		$province_id = clone $this->inputFilter->get('id');
		$province_id->setName('province_id');
		
		$city_id = clone $this->inputFilter->get('id');
		$city_id->setName('city_id');
		
		$district_id = clone $this->inputFilter->get('id');
		$district_id->setName('district_id');
		
		$school_id = clone $this->inputFilter->get('id');
		$school_id->setName('school_id');
		
		
		$this->inputFilter->add($year);
		$this->inputFilter->add($country_id);
		$this->inputFilter->add($province_id);
		$this->inputFilter->add($city_id);
		$this->inputFilter->add($district_id);
		$this->inputFilter->add($school_id);
		
		
		
		return $this->inputFilter;
		
	}
	
	
	
	
	
}