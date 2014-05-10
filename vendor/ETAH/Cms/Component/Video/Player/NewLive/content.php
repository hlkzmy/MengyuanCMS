<?php

namespace Etah\Cms\Component\Video\Player\NewLive;

use Etah\Mvc\Controller\BaseController as EtahMvcBaseController;
use Etah\Common\OperationSystem\Info as OperationSystemInfo;
use Etah\Common\File\Info as FileInfo;
use Etah\Common\Stream\Rtmp;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;


class Content extends EtahMvcBaseController{
	
	
	protected $contentReturnType  = 'viewModel';
	
	protected $controller = NULL;
	
	
	/**
	 * 设置render方法返回的类型，是字符串型的html，还是对象性质的viewModel
	 * @param string $contentReturnType
	 * @return \Etah\Cms\Component\Video\Player\Live\Content
	 */
	public function setContentReturnType($contentReturnType){
		$this->contentReturnType = $contentReturnType;
		return $this;
	}
	
	/**
	 * 设置所要拉取的视频流的数组列表
	 * @param  array $streamList
	 */
	public function setStreamList($streamList){
	
		if(!is_array($streamList) || sizeof( $streamList )==0){
			throw new \Exception('没有查询到当前教室的视频流，请在后台中设置或联系网站管理员');
		}
	
		$this->streamList = $streamList;
		return $this;
	}//function setStreamList() end
	
	/**
	 * 设置拉流的录播服务器的IP地址
	 * @param  array $recordServerIp
	 */
	public function setRecordServerIp($recordServerIp){
		$this->recordServerIp = $recordServerIp;
		return $this;
	}//function setStreamList() end
	
	
	public function setController($controller){
		$this->controller = $controller;
		return $this; 
	}
	
	
	private function checkMemberVarible(){
		
		$array = array('contentReturnType','streamList','recordServerIp','controller');
		
		foreach($array as $key=>$memberVarible){
			
			if(!isset($this->{$memberVarible}) || $this->{$memberVarible}==NULL ){
				die(  sprintf('使用直播播放器的时候没有对成员变量%s进行初始化',$memberVarible));
			}
		}
		
	}//function checkMemberVarible() end
	

	
	public function render(){
		
		$this->checkMemberVarible();
		
		//第一步:进行拉流操作，把学校录播服务器上的视频流拉到资源平台上
		$config = $this->serviceManager->get('config');
		$websiteConfig = $config['website'];
		
		$localServerIp = $websiteConfig['local_server_ip'];
		
		$rtmp = new Rtmp();
		
		try{
				
			$streamNameList = array();
				
				foreach($this->streamList as $stream){
			
				if(trim($stream['name'])==''){
					continue;
				}
		
				array_push($streamNameList,$stream['name']);
		
				$sourceStreamName      = $stream['name'];
		
				$destinationStreamName = sprintf("%s?adbe-live-event=classroom",$sourceStreamName);
				
				$rtmp->setSourceServerParameter($this->recordServerIp,'teach_app','123',$sourceStreamName,'1111',1935);
				$rtmp->setDestinationServerParameter($localServerIp,'teach_app','12345678',$destinationStreamName,'1111',1935);
				
				
				$rtmp->pushStream();
		
			}
				
		}
		catch(\Exception $e){
			
			$this->controller->jsReturnMessage($e->getMessage());
		}
		
		$viewModel = new ViewModel();
		
		//第二步:得到浏览器的相关信息
		$userAgentString = $this->controller->getRequest()->getHeader('useragent');
		$userAgentString = get_object_vars($userAgentString);
		$userAgentString = $userAgentString['value'];
		
		$operationSystemName = OperationSystemInfo::getOperationSystem($userAgentString);
		
		$notice = '';
		
		if(in_array($operationSystemName,array('windows','linux','android'))){
			$streamNameListJavascriptArray = sprintf("['%s']",implode("','",$streamNameList));
			$viewModel->setVariable('localServerIp',$_SERVER['HTTP_HOST']);
			$viewModel->setVariable('streamNameListJavascriptArray',$streamNameListJavascriptArray);
			$viewModel->setTemplate('Component/Video/Player/NewLive/Template/flash-player');
		}
		else if($operationSystemName=='ios'){

		//if(true){
		
			$streamName = $streamNameList[0];
				
			$liveStreamUrl = sprintf("http://%s:8134/etah-ios-live/_definst_/classroom/%s.m3u8",$_SERVER['HTTP_HOST'],$streamName);
				
			$viewModel->setVariable('liveStreamUrl', $liveStreamUrl);
				
			$viewModel->setTemplate('Component/Video/Player/NewLive/Template/html5-player');
		}
		else{
			$notice.= '系统没有设别出您的操作系统类型，默认用flash播放器为您播放视频';
		}
		
		
		
		$viewModel->setVariable('notice', $notice);
		
		if(strtolower( $this->contentReturnType )=='html'){
			
			$phpRenderer = $this->serviceManager->get ( 'Zend\View\Renderer\PhpRenderer' );
			
			$html = $phpRenderer->render($viewModel);
			
			return $html;
			
		}
		else if( $this->contentReturnType =='viewModel'){
			return $viewModel;
		}
		
	}//function renderTemplate() end
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}//class Common end