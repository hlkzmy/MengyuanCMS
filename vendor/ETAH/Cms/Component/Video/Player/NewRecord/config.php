<?php

namespace Etah\Cms\Component\Video\Player\NewRecord;

use Zend\Form\Element\Hidden;

use Zend\Form\Form;
use Zend\Form\Element\Text;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Radio;


class Config extends Form{
	
	function __construct(){
		
		parent::__construct('ConfigForm');
		
		$this->setAttribute('method'	,'post');
		$this->setAttribute('class'		,'pageForm required-validate');
		$this->setAttribute('onsubmit'	,'return validateCallback(this)');
		
		
		$windowsPlayerType =  new Radio();
		$windowsPlayerType->setName('windows_player_type');
		$windowsPlayerType->setLabel('windows操作系统播放器选择');
		$windowsPlayerType->setChecked('flash');
		$windowsPlayerType->setValueOptions(
											 array(
												'html5'=>'使用html5标签播放',
												'flash'=>'使用flash播放器播放'
											 ));
		
		$linuxPlayerType =  new Radio();
		$linuxPlayerType->setName('linux_player_type');
		$linuxPlayerType->setLabel('linux操作系统播放器选择');
		$linuxPlayerType->setChecked('flash');
		$linuxPlayerType->setValueOptions(
											array(
													'html5'=>'使用html5标签播放',
													'flash'=>'使用flash播放器播放'
											));
		
		
		
		$iosPlayerType =  new Radio();
		$iosPlayerType->setName('ios_player_type');
		$iosPlayerType->setLabel('ios操作系统播放器选择');
		$iosPlayerType->setChecked('html5');
		$iosPlayerType->setValueOptions(
										array(
												'html5'=>'使用html5标签播放',
										));
		
		$androidPlayerType =  new Radio();
		$androidPlayerType->setName('android_player_type');
		$androidPlayerType->setLabel('android操作系统播放器选择');
		$androidPlayerType->setChecked('html5');
		$androidPlayerType->setValueOptions(
											array(
													'html5'=>'使用html5标签播放',
													'flash'=>'使用flash播放器播放'
											));
		
		
	  	$this->add($windowsPlayerType);
	  	$this->add($linuxPlayerType);
		$this->add($iosPlayerType);
		$this->add($androidPlayerType);
		
	}//function __construct() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class ConfigForm end


?>