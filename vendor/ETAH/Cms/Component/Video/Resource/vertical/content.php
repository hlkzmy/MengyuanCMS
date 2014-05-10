<?php

namespace Etah\Cms\Component\Video\Resource\vertical;

use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;
use Etah\Common\OperationSystem\Info as OperationSystemInfo;

class Content{
	
	private $serviceManager = null;
	
	function __construct($serviceManager){
		
		$this->serviceManager = $serviceManager;
		
	}
	
	/**
	 * 通过解析内容配置文件 来获取模板中需要的各种数据
	 * 把这部分解析的内容从前台中分离出来，最大的好处就是不需要在网站前台中适应各种内容组件的数据查询方法，
	 * 因为根本不可能适应各种各样的内容组件的方法，那样的话解析配置文件的时候是需要复杂到什么程度的switch 或者  if
	 * 这样的话也很难让第三方的用户进来编辑内容组件，因为每做一个内容组件，都需要在网站前台中解析页面的时候添加一种情况
	 * 
	 * 为了解决以上的问题：
	 * 1.网站前台调用的时候，通过数据库的路径拼接得到内容组件的形成内容的php文件，统一命名为content.php ,文件中的类的名称为  class content{}
	 * 
	 * 2.网站后台调用的时候，通过数据库的路径拼接得到内容组件的形成配置界面的php文件，统一命名为config.php,文件中的类的名称为 class config{}
	 * 
	 * 3.形成配置界面的php文件通过类似于生成添加对象的界面返回给后台的都是一个post的数组，只不过 create界面需要有参数解析然后选择进行各种操作的checkcreate
	 *   配置界面形成的POST数组只需要被序列化，然后存进数据库，然后在形成页面的时候可以被自己解析出来就可以
	 *   
	 * 4.整个过程实际上就是内容组件自己配置自己，自己解析自己的过程，系统完全不参与，系统只负责在合适的时候新建一下内容组件的对象，然后调一下统一对象就可以了
	 * 
	 * 5.内容组件实际上就是提供给用户选择数据来源，存放数据来源，解析数据来源，渲染组件模板，它不停被系统所调用，把形成的字符串返回系统，然后参与构成页面的过程
	 * 
	 * @param object $controller
	 * @param object $contentConfig
	 * @return array data
	 */
	
	private function getDataByParseContentConfig($controller,$contentConfig){
		
		$contentConfig  = unserialize($contentConfig);
		
		//第一步：检验参数
		$this->checkContentConfigParameter($controller,$contentConfig);
		
		//系统种类，因为当系统是iso时可以直接预览课件。
		
		$userAgentString = $controller->getRequest()->getHeader('useragent');
		$userAgentString = get_object_vars($userAgentString);
		$userAgentString = $userAgentString['value'];
		
		$operationSystemName = OperationSystemInfo::getOperationSystem($userAgentString);
		
		$preview = false;
		if($operationSystemName=='ios'){
			$preview = true;
		}
		
		
		//第二步：解析内容,每个内容组件这部分都不一样
		
		//1.取得要显示的资源相关信息
		$columns = $contentConfig['columns'];
		
		$videoId = $controller->getEvent()->getRouteMatch()->getParam('id');
		
		$videInfo = $controller->videoModel->getRowById($videoId,array('id','video_sort_id'));
		
		if (!is_array($videInfo) || sizeof($videInfo) < 1){
			die('不存在对应id的视频，请勿非法操作');
		}
		
		
		//2.查询视频的列表
		
		if (!isset($videInfo['video_sort_id']) || !is_numeric($videInfo['video_sort_id'])){
			die('该视频没有分类，无法找到相关资源');
		}
		
		$videoSortId = $videInfo['video_sort_id'];
		
		$descendantVideoSortColumns = array('id','name');
		
		$tempDescendantVideoSortIdList = $controller->videoSortModel->getDescendantRowListById($videoSortId,$descendantVideoSortColumns);
		
		$descendantVideoSortIdList = array();
		
		foreach($tempDescendantVideoSortIdList as $videoSort){
			array_push($descendantVideoSortIdList,$videoSort['id']);
		}
		$videoList = array();
		
		if (sizeof($descendantVideoSortIdList) > 0 ){
			
			$where = new where();
			$where->in('video_sort_id',$descendantVideoSortIdList);
			$where->notEqualTo('id', $videoId);
			
			$videoLimit   = $contentConfig['video_limit'];
			
			$videoList = $controller->videoModel->getRowByCondition($where,array('id','name','thumb','user_id','video_sort_id'),$videoLimit);
			
			$userIdList = array();
			$videoSortIdList = array();
			
			foreach ($videoList as $video){
				array_push($userIdList, $video['user_id']);
				array_push($videoSortIdList, $video['video_sort_id']);
			}
			//查询用户
			$userList = array();
			
			if (sizeof($userIdList) > 0){
				$userTempList = $controller->userModel->getRowById($userIdList,array('id','realname'));
				foreach ($userTempList as $user){
					$userList[$user['id']] = $user['realname'];
				}
			}
			
			//查询分类
			
			$videoSortList = array();
			
			if (sizeof($videoSortIdList) > 0){
				$videoSortTempList = $controller->videoSortModel->getRowById($videoSortIdList,array('id','name'));
				foreach ($videoSortTempList as $videoSort){
					$videoSortList[$videoSort['id']] = $videoSort['name'];
				}	
			}

			
		}
		
		//3.查询课件的列表
		
		$where = new where();
		
		$where->equalTo('video_id', $videoId);
		
		$coursewareLimit   = $contentConfig['courseware_limit'];
		
		$coursewareList = $controller->coursewareModel->getRowByCondition($where,array('id','name','hash'),$coursewareLimit);
		
		
		//4.方便模板做出的一些改动，主要是形成冗长的URL
		
		$basePath = dirname(dirname($controller->getRequest()->getBasePath()));
		foreach($videoList as $key=>$video){
			
			$videoList[$key]['img_src']   = sprintf("%s/%s/%s/%s_116x87.jpg",$basePath,'media/video',$video['id'],$video['thumb']);
			
			$videoList[$key]['title_url'] = $controller->url()->fromRoute('resource',array('controller'=>'video','action'=>'play','id'=>$video['id']));
																							
			$videoList[$key]['img_url']   = $videoList[$key]['title_url'];
			
			$videoList[$key]['fullname']      = $video['name'];
			
			$videoList[$key]['name']   = $this->SubStrLen($video['name'],0,10,'UTF-8');
			
			$videoList[$key]['realname'] = isset($userList[$video['user_id']])?$userList[$video['user_id']]:'';
			
			$videoList[$key]['video_sort'] = isset($videoSortList[$video['video_sort_id']])?$videoSortList[$video['video_sort_id']]:'';
			
		}
		
		foreach ($coursewareList as $key=>$courseware){
			
			$coursewareList[$key]['name'] = $this->SubStrLen($courseware['name'],0,$preview?20:30,'UTF-8');
			$coursewareList[$key]['title_url'] = $controller->url()->fromRoute('resource',array('controller'=>'courseware','action'=>'showCourseware','id'=>$courseware['id']));
			$coursewareList[$key]['preview']   = $preview?(sprintf("%s/%s/%s/%s",$basePath,'media/courseware',$courseware['id'],$courseware['hash'])):false;
		
			$ext = strrchr($courseware['hash'],'.');

			switch ($ext){
				
				case '.ppt':{
					$class = 'img_ppt';
				};break;
				case '.pptx':{
					$class = 'img_ppt';
				};break;
				case '.doc':{
					$class = 'img_word';
				};break;
				case '.docx':{
					$class = 'img_word';
				};break;
				case '.xlsx':{
					$class = 'img_excel';
				};break;
				case '.xls':{
					$class = 'img_excel';
				};break;
				case '.rar':{
					$class = 'img_zip';
				};break;
				case '.zip':{
					$class = 'img_zip';
				};break;
				case '.html':{
					$class = 'img_html';
				};break;
				case '.htm':{
					$class = 'img_html';
				};break;
				case '.jpg':{
					$class = 'img_image';
				};break;
				case '.png':{
					$class = 'img_image';
				};break;
				case '.pdf':{
					$class = 'img_pdf';
				};break;
				case '.text':{
					$class = 'img_text';
				};break;
				default:{
					$class = 'img_unknown';
				};
				
				
			}
			$coursewareList[$key]['class'] = $class;
				
				
		
		}
		
		
		//4.填装数据
																					
		$data['videoList'] 			 	= $videoList;
		
		$data['coursewareList']			 = $coursewareList;
		
		
		return $data;
		
	}//function formatData() end
	
	
	/**
	 * 用来检验内容组件的内容参数是否符合要求
	 */
	
	private function checkContentConfigParameter($controller,$contentConfig){
		
		$modelList = array('videoModel','videoSortModel','coursewareModel');
		
		foreach($modelList as $model){
			
			if(!isset($controller->{$model})){
				die(  sprintf('形成内容组件所需要的数据表%s在当前调用内容组件的控制器没有完成初始化',$model));
			}
		
		}
		
		
	}//function checkContentConfig() end
	
	
	public function render($controller,$contentConfig){
		
		$data = $this->getDataByParseContentConfig($controller,$contentConfig);
		
		$PhpRenderer = $this->serviceManager->get ( 'Zend\View\Renderer\PhpRenderer' );
		
		//加载所需要的js
		$basePath = $controller->getRequest()->getBasePath();
// 		$PhpRenderer->headScript()->appendFile($basePath.'/js/cms/component/tab.js');
		
		$viewModel = new ViewModel();
		$viewModel->setTemplate('Component/Video/Resource/vertical/template');
		
		$viewModel->setVariable('data', $data);
		
		$html = $PhpRenderer->render($viewModel);
		
		return $html;
	}//function renderTemplate() end
	
	private function SubStrLen($str,$off,$len,$charset,$ellipsis="…")
	{
		if(iconv_strlen($str,$charset)>$len){
			$str=iconv_substr($str,$off,$len,$charset).$ellipsis;
		}
		else{
			$str=iconv_substr($str,$off,$len,$charset);
		}
	
		return $str;
	}
	
	
	
	
	
}//class Common end