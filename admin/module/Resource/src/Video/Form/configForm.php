<?php
namespace Video\Form;

use Zend\Form\Element\Radio;

use Zend\Form\Element\Checkbox;

use Zend\Form\Element\Hidden;

use Zend\Form\Form;
use Zend\Form\Element\Text;


class ConfigForm extends Form{

	function __construct(){

		parent::__construct('FrontendConfigForm');

		$this->setAttribute('method'	,'post');
		$this->setAttribute('class'		,'pageForm required-validate');
		$this->setAttribute('onsubmit'	,'return validateCallback(this)');

		
		$start_time = new Text();
		$start_time->setName('start_time');
		
		$end_time = new Text();
		$end_time->setName('end_time');
		
		$concurrent = new Text();
		$concurrent->setName('concurrent');
		
// 		$transcode = new Radio();
// 		$transcode->setName('need_convert_format');
// 		$transcode->setValueOptions(array('1'=>'自动转码','0'=>'不转码'));
		
// 		$transcode_num = new Text();
// 		$transcode_num->setName('video_convert_format_count');

		$this->add($start_time);
		$this->add($end_time);
		$this->add($concurrent);
		//$this->add($transcode);
		//$this->add($transcode_num);

	}//function __construct() end





}//class ConfigForm end