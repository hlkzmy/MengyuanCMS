<?php

namespace Etah\Common\Stream;

use Zend\Validator\Ip as IpValidator;
use Zend\Validator\Digits as DigitsValidator;

class Rtmp
{
     
	 private $sourceServerIp 		 	= null;
	 private $sourceAppName				= null;
	 private $sourceServerStreamName 	= null;
	 private $sourceAdminPort			= null;
	 private $sourceServerFmsPort 		= null;
	 private $sourceServerFmsPassword 	= null;
	 
	 private $destinationServerIp 		 	= null;
	 private $destinationAppName			= null;
	 private $destinationServerStreamName 	= null;
	 private $destinationAdminPort	 		= null;
	 private $destinationServerFmsPort 		= null;
	 private $destinationServerFmsPassword 	= null;
	 
	 public function setSourceServerParameter($ip,$sourceAppName,$fmsPassword,$streamName,$sourceAdminPort,$fmsPort){
	 	
	 	   $this->sourceServerIp 			= $ip;
	 	   $this->sourceServerStreamName 	= $streamName;
	 	   $this->sourceAppName 			= $sourceAppName;
	 	   $this->sourceServerFmsPassword 	= $fmsPassword;
	 	   $this->sourceAdminPort			= $sourceAdminPort;
	 	   $this->sourceServerFmsPort 		= $fmsPort;
	 }//function setSourceServerParameter() end
	
	 public function setDestinationServerParameter($ip,$destinationAppName,$fmsPassword,$streamName,$destinationAdminPort,$fmsPort){

			 $this->destinationServerIp 			= $ip;
			 $this->destinationAppName				=$destinationAppName;
			 $this->destinationServerStreamName 	= $streamName;
			 $this->destinationAdminPort 			= $destinationAdminPort;
			 $this->destinationServerFmsPassword 	= $fmsPassword;
			 $this->destinationServerFmsPort 		= $fmsPort;
			 
			 
	 }//function setDestinationServerParameter() end
	
	 private function checkPushStreamParameter(){
	 	
	 	$ipValidator = new IpValidator();
	 	$ipValidator->setOptions(  array('allowipv6'=>false));
	 	
	 	if(!$ipValidator->isValid($this->sourceServerIp)){
	 		 throw new \Exception('源服务器的ip地址不是一个有效的ipV4地址');
	 	}
	 	
	 	if(!$ipValidator->isValid($this->destinationServerIp)){
	 		throw new \Exception('目标服务器的ip地址不是一个有效的ipV4地址');
	 	}
	 	
	 	$digitsValidator = new DigitsValidator();
	 	
	 	if(!$digitsValidator->isValid($this->sourceServerFmsPort)){
	 		throw new \Exception('源服务器的FMS端口不是一个有效值');
	 	}
	 	 
	 	if(!$digitsValidator->isValid($this->destinationServerFmsPort)){
	 		throw new \Exception('目标服务器的FMS端口不是一个有效值');
	 	}
	 	
	 }//function checkPushStreamParameter() end
	 
	 public function pushStream(){
	 	
	 	$this->checkPushStreamParameter();
	 	
	 	$statusCode = push_stream(
	 			
	 		/*	"172.16.1.132",
		"teach_app","12345678",
		"VE0101000532_h",1111,1935,"172.16.135.171","teach_app","123","VE0101000532_h",1111,1935*/
 								 	  $this->destinationServerIp,
	 								 $this->destinationAppName,
	 								 $this->destinationServerFmsPassword,
								 	 $this->destinationServerStreamName,
	 								 $this->destinationAdminPort,
								 	 $this->destinationServerFmsPort,
	 			
							 			$this->sourceServerIp,
							 			$this->sourceAppName,
							 			$this->sourceServerFmsPassword,
							 			$this->sourceServerStreamName,
							 			$this->sourceAdminPort,
							 			$this->sourceServerFmsPort  
								 	 
								 );
	 	
	 	$statusCode = intval($statusCode);
	 	
	 	
// 	 	echo 'destinationServerIp:';echo $this->destinationServerIp;echo '<br>';
// 	 	echo 'destinationAppName:';echo $this->destinationAppName;echo '<br>';
// 	 	echo 'destinationServerFmsPassword:';echo $this->destinationServerFmsPassword;echo '<br>';
// 	 	echo 'destinationServerStreamName:';echo $this->destinationServerStreamName;echo '<br>';
// 	 	echo 'destinationAdminPort:';echo $this->destinationAdminPort;echo '<br>';
// 	 	echo 'destinationServerFmsPort:';echo $this->destinationServerFmsPort;echo '<br>';
	 	
// 	 	echo 'sourceServerIp:';echo $this->sourceServerIp;echo '<br>';
// 	 	echo 'sourceAppName:';echo $this->sourceAppName;echo '<br>';
// 	 	echo 'sourceServerFmsPassword:';echo $this->sourceServerFmsPassword;echo '<br>';
// 	 	echo 'sourceServerStreamName:';echo $this->sourceServerStreamName;echo '<br>';
// 	 	echo 'sourceAdminPort:';echo $this->sourceAdminPort;echo '<br>';
// 	 	echo 'sourceServerFmsPort:';echo $this->sourceServerFmsPort;echo '<br>';

	 	
	 	
	 	switch($statusCode){
	 		
	 		case 100:throw new \Exception('源服务器或目标服务器的FMS登录失败');break;
	 		case 101:throw new \Exception('源服务器或目标服务器的FMS登录失败');break;
	 		case 102:throw new \Exception('当前视频流不是直播流');break;
	 		case 103:throw new \Exception('当前视频流格式不正确');break;
// 	 		case 104:throw new \Exception('当前流不存在');break;
	 		case 105:throw new \Exception('未知错误，请联系网站管理员');break;
	 		default:;
	 	}
	 	
	 	
	 }//function pushStream() end
	
    
    
}//class Rtmp
