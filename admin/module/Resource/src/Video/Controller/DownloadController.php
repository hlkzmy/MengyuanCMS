<?php

namespace Video\Controller;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogWriter;
use Zend\View\Model\ViewModel;
use Base\Controller\BaseController;

use Zend\Config\Config 			as PhpArrayConfigManager;
use Zend\Config\Writer\PhpArray as PhpArrayConfigWriter;

use Etah\Common\Folder\Travel as FolderTravel;

use Video\Form\ConfigForm;

use Zend\Db\Sql\Where;


class DownloadController extends BaseController
{
   
	public function __construct(){
   	
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoFilterModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoPlayinfoModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoSortModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','AreaModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','SchoolModel');
		
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Video','VideoForm');
		
		//注册Filter对象
		$this->registFilter($this->serviceManager, 'VideoFilter');
		
		$this->registFilter($this->serviceManager, 'VideoFilterFilter');
		
		$this->registFilter($this->serviceManager, 'VideoPlayInfoFilter');
		
   }//function __construct() end
	
   
   
   public function getVideoSortIdLookupHref(){
   	
   	   $routeParam = array( 
   	   						'controller'=>'video',
   	   						'action'=>'lookup',
   	   						'source'=>'resource.video.create',
   	   						'name'=>'video_sort_id'
   	   					 );
   	
   	   $url =  $this->url()->fromRoute('resource',$routeParam);
   	   
   	   return $url;
   	   
   }//function getLookupString() end
   
   public function getSchoolIdLookupHref(){
   	
   		$routeParam = array(
   							'controller'=>'video',
   							'action'=>'lookup',
   							'source'=>'resource.video.create',
   							'name'=>'school_id'
   					      );
   	    
   		$url =  $this->url()->fromRoute('resource',$routeParam);
   	 
   		return $url;
   		
   }//function getAreaIdLookupString() end
   
   public function getSchoolIdLookupPostUrl(){
   
   		$url =  $this->url()->fromRoute('resource',array('controller'=>'video','action'=>'append'));
   	 
   		return $url;
   
   }//function getVideoSortIdLookupPostUrl() end
   
   public function getVideoSortIdLookupPostUrl(){
   	
   		$url =  $this->url()->fromRoute('resource',array('controller'=>'video','action'=>'append'));
   	 
   		return $url;
   	
   }//function getVideoSortIdLookupPostUrl() end
   
   public function getDownloadProcess($data){
   	
   	    $videoId = $data['id'];
   	   
   	    $folderPath = sprintf("%s/%s/%s",WEBSITE_DISK_PATH,'media/video',$videoId);
   	    
   	    if(!is_dir($folderPath)){
   	    //如果文件不存在的话，那么肯定是下载还没有开始，所以返回是0
   	    	return 0;
   	    }
   	    
   	    $filePathList =  FolderTravel::getChildFileList($folderPath,array('mp4'),true);
   	    //遍历得到视频夹的mp4文件的列表
   	    
   	    $downloadedTotalSize = FolderTravel::getFileListTotalSize($filePathList);
   	    //计算得到文件列表的总共大小
   	    
   	    $videoDownloadInfo = $this->videoModel->getRowById($videoId,array('download_info'));
   	    
   	    $videoDownloadInfo = json_decode(  $videoDownloadInfo['download_info']  ,  true  );
   	    //存储在数据库中的信息是JSON格式的，计算百分比只需要一个totalSize
   	    
   	    $expectedTotalSize = $videoDownloadInfo['totalSize'];
   	    
   	    if($expectedTotalSize==0){
   	    	$this->videoModel->updateRowById($videoId,array('download_status'=>'error'));
   	    	return 0;
   	    }
   	    
   	    $percentage = ( $downloadedTotalSize/1024 ) / $expectedTotalSize;
   	    
   	    $percentage = $percentage*100;
   	    
   	    if($percentage>99){
   	    	$percentage = 99;
   	    }
   	    
   	    return  $percentage;
   	
   }//function getDownloadProcess() end
   
   /**
    * 用来显示后台上关于视频下载的配置
    * @return \Zend\View\Model\ViewModel
    */
   
   public function configAction(){
   	
   		$CustomerConfigPath  = WEBSITE_DISK_PATH."/soap/config/customer/video.download.config.php";
	   	
	   	$CustomerConfigArray = $this->FormatConfigArray($CustomerConfigPath);
	   	
	   	$configForm = new ConfigForm();
	   	
	   	$url = $this->url()->fromRoute('resource',array('controller'=>'Download','action'=>'checkVideoDownloadConfig'));
	   	
	   	$configForm->setAttribute('action', $url);
	   	
	   	foreach ($CustomerConfigArray as $customerConfig){
	   		
	   		$name = $customerConfig['name'];
	   		
	   		${$name} = $configForm->get($name);
	   		
	   		${$name}->setLabel($customerConfig['title']);
	   		
	   		if(isset($customerConfig['type']) && $customerConfig['type'] == 'time'){
	   			${$name}->setAttribute('size','20');
	   			${$name}->setAttribute('class','date');
	   			${$name}->setAttribute('dateFmt','HH:mm:ss');
	   			${$name}->setAttribute('readonly','true');
	   		}
	   		
	   		${$name}->setValue($customerConfig['value']);
	   		
	   		${$name}->setInfo($customerConfig['info']);
	   		
	   	}
	   	
	   	$viewModel = new ViewModel ();
	   	
	   	$viewModel->setVariable('CustomerConfigForm', $configForm);
	   	
	   	return $viewModel;
   	
   }//function showDownloadConfigAction() end
   
   
   /**
    * 用来保存在后台页面上修改的视频下载页面的配置
    */
   public function checkVideoDownloadConfigAction(){
   
	   	$request = $this->getRequest();
	   
	   	if (!$request->isXmlHttpRequest()) {
	   		$this->returnMessage('300', '请不要尝试非法访问');
	   	}
	   
	   	$postData = $request->getPost()->toArray();
	   	//得到从表单提交的数据
	   
	   	$postData = array('video_download_config'=>$postData);
	   	//把收到的数据作为数组下的一个键值
	   
	   	$ConfigManager = new PhpArrayConfigManager($postData,true);
	   	//新建配置文件管理器
	   
	   	$CustomerConfigPath = WEBSITE_DISK_PATH."/soap/config/customer/video.download.config.php";
	   	//网站前台的配置文件的路径
	   
	   	$configWriter = new PhpArrayConfigWriter();
	   
	   	try{
	   			
	   		$configWriter->toFile($CustomerConfigPath, $ConfigManager);
	   			
	   	}
	   	catch(\Exception $e){
	   			
	   		$this->ajaxReturn(300,$e->getMessage().'修改配置文件失败，请联系网站程序员！');
	   	}
	   
	    $this->ajaxReturn(200,'恭喜您，修改配置文件成功！');
   
   }//function CheckFrontendConfigAction() end
   
   
   public function getDownloadStatusString($data){
   	
   	 	$downloadStatus = $data['download_status'];
   	  	
   	 	switch($downloadStatus){
   	 		
   	 		case 'notstarted':$downloadStatusString = '未开始';break;
   	 		case 'processing':$downloadStatusString = '进行中';break;
   	 		case 'finished':$downloadStatusString = '已完成';break;
   	 		case 'error':$downloadStatusString = '发生错误';break;
   	 		case 'stopped':$downloadStatusString = '手工停止';break;
   	 		case 'converting':$downloadStatusString = '视频转码中';break;
   	 		default:$downloadStatusString='';
   	 	}
   		
   	 	
   	 	return $downloadStatusString;
   	
   }//function getDownloadStatusString() end
   
   
   public function startAction(){
   	
   	   $request = $this->getRequest();

   	   if(!$request->isXmlHttpRequest()){
   	   		die('请不要尝试非法操作，谢谢您的合作');
   	   }
   	
   	   $postData = $request->getPost()->toArray();
   	   
   	   // 此处开启数据事务
   	   $dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
   	   $dbConnection->beginTransaction();
   	   
   	   try{
	    		
   	   		$videoIdList = $postData['ids'];

   	   		foreach($videoIdList as $videoId){
   	   			$this->videoModel->updateRowById($videoId,array('download_status'=>'processing'));
   	   		}
   	   	
   	   	}
	    catch (\Exception $e ) {
	   
	    	$dbConnection->rollback ();
	    	$this->ajaxReturn (300, $e->getMessage () );
	    }
   	
	    $dbConnection->commit();
   	    $this->ajaxReturn(200,'所选视频将开始下载！');
   	    
   }//function startAction() end
   
   public function stopAction(){
   	
	   	$request = $this->getRequest();
	   	
	   	if(!$request->isXmlHttpRequest()){
	   		die('请不要尝试非法操作，谢谢您的合作');
	   	}
	   	
	   	$postData = $request->getPost()->toArray();
	   		
	   	// 此处开启数据事务
	   	$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
	   	$dbConnection->beginTransaction();
	   		
	   	try{
	   		 
	   		$videoIdList = $postData['ids'];
	   		 
	   		foreach($videoIdList as $videoId){
	   			$this->videoModel->updateRowById($videoId,array('download_status'=>'stopped'));
	   		}
	   	
	   	}
	   	catch (\Exception $e ) {
	   	
	   		$dbConnection->rollback ();
	   		$this->ajaxReturn (300, $e->getMessage () );
	   	}
   	
	   	
	   	$dbConnection->commit();
	   	$this->ajaxReturn(200,'所选视频将停止下载！');
	   	
   }//function stoppedAction() end
   
   public function cancelAction(){
   
	   	$request = $this->getRequest();
	   	 
	   	if(!$request->isXmlHttpRequest()){
	   		die('请不要尝试非法操作，谢谢您的合作');
	   	}
	   	 
	   	$postData = $request->getPost()->toArray();
	   
	   	// 此处开启数据事务
	   	$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
	   	$dbConnection->beginTransaction();
	   
	   	try{
	   		 
	   		$videoIdList = $postData['ids'];

	   		$where = new Where();
	   		$where->in('id',$videoIdList);
	   		
	   		$this->videoModel->deleteRowByCondition($where);
	   		$this->videoPlayinfoModel->deleteRowByCondition($where);
	   		$this->videoFilterModel->deleteRowByCondition($where);
	   	}
	   	catch (\Exception $e ) {
	   	  
	   		$dbConnection->rollback ();
	   		$this->ajaxReturn (300, $e->getMessage () );
	   	}
	   
	   	 
	   	$dbConnection->commit();
	   	$this->ajaxReturn(200,'所选视频已经从下载列表中移除！');
   }//function stoppedAction() end
   
   
   
   private function FormatConfigArray($CustomerConfigPath){
   	//格式化配置数组，把配置文件读出来，然后显示在界面上
   	//重要思想把二维数组转化为一维数组
   	//配置项使用的中文汉字title，input标签使用的name值  name，input标签使用的value值 value
   	//是否横跨单元格，就是只是一个键值，而无具体配置项 colspan = 3
   
   	if(!file_exists($CustomerConfigPath)){
   		die('网站用户自定义配置文件丢失');
   	}
   
   	$CustomerConfigArray = require_once($CustomerConfigPath);
   	//这个数组存储每个配置项的键名和对应的键值
   
   	$CustomerConfigArray = $CustomerConfigArray['video_download_config'];
   	//访问其中的video_download_config键值
   
   	$DirectoryPath = dirname($CustomerConfigPath);
   	//得到存储配置文件中提示信息的文件夹的路径
   
   	$FileName  = basename($CustomerConfigPath,'.config.php').'.notice.php';
   	//得到存储配置文件中提示信息的文件的名称
   
   	$CustomerConfigNoticePath = $DirectoryPath.'/'.$FileName;
   	//拼接得到配置文件的提示信息数组
   
   	if(!file_exists($CustomerConfigNoticePath)){
   		die('网站用户自定义配置提示文件丢失');
   	}
   
   	$CustomerConfigNoticeArray = require_once($CustomerConfigNoticePath);
   
   	$CustomerConfigNoticeArray = $CustomerConfigNoticeArray['video_download_config'];
   
   	$result = array();
   
   	foreach($CustomerConfigArray as $outer_key=>$ConfigElement){
   
   		if(is_array($ConfigElement)){
   
   			$tempConfigElement = array();
   			$tempConfigElement['title']   = $CustomerConfigNoticeArray[$outer_key]['title'];
   			$tempConfigElement['colspan'] = 3;
   
   
   			array_push($result,$tempConfigElement);
   
   			foreach($ConfigElement as $inner_key=>$ChildConfigElement){
   
   				$tempChildConfigElement = array();
   				$tempChildConfigElement['title']   = $CustomerConfigNoticeArray[$outer_key][$inner_key]['title'];
   				$tempChildConfigElement['info']    = $CustomerConfigNoticeArray[$outer_key][$inner_key]['info'];
   				$tempConfigElement['type']    	   = isset($CustomerConfigNoticeArray[$outer_key]['type'])?$CustomerConfigNoticeArray[$outer_key]['type']:null;
   				$tempChildConfigElement['name']    = $outer_key."[".$inner_key."]";
   				$tempChildConfigElement['value']   = $ChildConfigElement;
   
   				array_push($result,$tempChildConfigElement);
   			}
   				
   		}
   		else{
   
   			$tempConfigElement = array();
   			$tempConfigElement['title']   = $CustomerConfigNoticeArray[$outer_key]['title'];
   			$tempConfigElement['info']    = $CustomerConfigNoticeArray[$outer_key]['info'];
   			$tempConfigElement['type']    = isset($CustomerConfigNoticeArray[$outer_key]['type'])?$CustomerConfigNoticeArray[$outer_key]['type']:null;
   			$tempConfigElement['name']    = $outer_key;
   			$tempConfigElement['value']   = $ConfigElement;
   
   			array_push($result,$tempConfigElement);
   		}
   
   	}//foreach end
   	
   	return $result;
   	
   }//function FormatConfigArray() end
   
   
   public function uploadAction()
   {
	   	$logger = new Logger();
	   	
	   	$logWriter = new LogWriter('phpHelper.log');
	   	
	   	$logger->addWriter($logWriter);
	   	
   		try {
		   	
   			$CustomerConfigPath  = WEBSITE_DISK_PATH."/frontend/config/customer/website.php";
   			
   			$CustomerConfigArray = require $CustomerConfigPath;
   			 
   			$self_ip = $CustomerConfigArray['website']['local_server_ip'];
   			 
   			$upload_ip = $CustomerConfigArray['website']['parent_server_ip'];
   			
   			$self_school_id = $CustomerConfigArray['website']['local_school_id'];
   			
   			$recordServerAddress = sprintf("http://%s/platform/soap/public/?wsdl",$upload_ip);
   			
   			$totalSize = 0;
   			
   			$type = array('d','f','b','c','x');
   			
		   	$where = new Where();
		   	$where->equalTo('upload_status', 'enupload');
		   	$where->equalTo('download_status', 'finished');
		   	$where->equalTo('status', 'Y');
		   	
		   	$upload_video_list = $this->videoModel->getRowByCondition($where);
		   	
		   	if (sizeof($upload_video_list) < 1){
		   		$logger->info('没有需要上传的文件');
		   		exit;
		   	}
		   	
		   	
		   	//查出需要上传的数据后多次调用webservice来上传数据
		   	foreach ($upload_video_list as $video){
		   		
		   		$record_type = $video['record_type'];
		   		
		   		$where = new Where();
		   		$where->equalTo('id', $video['id']);
		   		$where->equalTo('chapter_number', 1);
		   		
		   		$video_play_info = $this->videoPlayinfoModel->getRowByCondition($where);
		   		
		   		if(isset($video_play_info[0])){
		   			
		   			$record_type = array();
		   			foreach ($video_play_info as $key=>$playinfo){
		   				$totalSize +=intval($playinfo['size']);
		   				array_push($record_type, $type[$key]);
		   			}
		   			$record_type = implode(',', $record_type);
		   		}else{
		   			$totalSize= $video_play_info['size'];
		   		}
		   		if($video['index'] !== ''){
		   			$index = json_decode($video['index']);
		   			$index->src = '/uploads';
		   		}else{
		   			$index = array('src'=>'/uploads',
		   					'filelist'=>''
		   			);
		   			
		   		}
		   		
		   		$logo= array(
		   						'src'=>'/uploads',
		   						'intro'=>''
		   				);
		   		$speaker = array(
		   						'src'=>'/uploads',
		   						'name'=>'',
		   						'sex'=>'',
		   						'intro'=>''
		   				);
		   		
		   		$folderName = $video['id']; 
		   		
		   		if (isset($video['download_info'])){
		   			$download_info = json_decode($video['download_info']);
		   			if (isset($download_info->folderName)){
		   				$folderName = $download_info->folderName;
		   			}
		   		}
		   		$SoapClient = new \SoapClient($recordServerAddress,array());
		   			
		   		$parameters  = array(
		   				'gatewayIp'=>$self_ip,
		   				'svrIp'  =>$self_ip,
		   				'schoolId'	=>$self_school_id,
		   				'user'=> 'anonymous',
		   				'pwd'=> 'anonymous',
		   				'videoId'=> '',
		   				'mediaId'=> $video['id'],
		   				'totalSize'=> $totalSize,
		   				'displayName'=> $video['name'],
		   				'folderName'=> $folderName,
		   				'recordType'=> $record_type,
		   				'chapterNum'=> $video['chapter_count'],
		   				'src'=> '/upload/'.$video['id'],
		   				'description'=> $video['description'],
		   				'index'=>$index,
		   				'logo'=>$logo,
		   				'speaker'=>$speaker,
		   				
		   				
		   		);
		   		$parameters = json_encode($parameters);
		   		
		   		$result = $SoapClient->__Call('recordHandler', array($parameters));
		   		
		   		$logger->info($result);
		   		
		   		$result = json_decode($result);
		   		
		   		if ($result->status == '200'){
		   			$this->videoModel->updateRowById($video['id'],array('upload_status'=>'uploaded'));
		   		}
		   		
		   	}
		   	
	   		
   		}catch (\Exception $e){
   			
   			
   			
   			$logger->err($e->getMessage());
   			
   			
   		}
   		
   		
   		
   		exit;
   }
   
   
 
	
			
   
}//class VideoController() end
