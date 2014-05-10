<?php

namespace Etah\Cms\Component\liveClassRoom\Common;

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
		
		//1：检验参数
		$this->checkContentConfigParameter($controller,$contentConfig);
		
		$limit   = $contentConfig['limit'];
		
		$title   = $contentConfig['title'];
		
		//2 查询数据
		
		$where = new Where();
		$where->notEqualTo('live_status', 'D');
		
		$order = array('id'=>'desc');
		
		$columns = array('id','school_id','video_name','subject_id','teacher_id','start_time');
		
		$liveClassroomList = $controller->liveClassroomModel->getRowByCondition($where,$columns,$limit,0, $order);
		
		//提取需要查询的信息
		
		$schoolIdList = array();
		$userIdList = array();
		$subjectIdList = array();
		
		foreach ($liveClassroomList as $liveClassroom){
			array_push($schoolIdList, $liveClassroom['school_id']);
			array_push($userIdList, $liveClassroom['teacher_id']);
			array_push($subjectIdList, $liveClassroom['subject_id']);
		}
		
		
		//获取用户信息列表
		$userTempInfoList = array();
		$userInfoList = array();

		
		if (sizeof($userIdList) > 0){
		
			$where = new Where();
			$where->in('id',$userIdList);
			
			$userTempInfoList = $controller->userModel->getRowByCondition($where,array('id','realname','school_id','photo'));
			foreach ($userTempInfoList as $user){
				$userInfoList[$user['id']]['realname'] = $user['realname'];
				$userInfoList[$user['id']]['photo'] = $user['photo'];
			}
		
		}
		//获取学校信息列表
		
		if (sizeof($schoolIdList) > 0){
			$schoolTempInfoList = array();
			$schoolInfoList = array();
			
			$where = new Where();
			$where->in('id',$schoolIdList);
			$schoolTempInfoList = $controller->schoolModel->getRowByCondition($where,array('id','name'));
			
			foreach ($schoolTempInfoList as $school){
				$schoolInfoList[$school['id']] = $school['name'];
			}
		}

		if (sizeof($subjectIdList) > 0){
		
			//获取学科信息列表
			$subjectTempList = array();
			$subjectInfoList = array();
			
			$where = new Where();
			$where->in('id',$subjectIdList);
			$subjectTempList = $controller->subjectModel->getRowByCondition($where,array('id','name'));
			
			foreach ($subjectTempList as $subject){
				$subjectInfoList[$subject['id']] = $subject['name'];
			}
		}
		
		//3 形成数据 ，url等
		$basePath = dirname(dirname($controller->getRequest()->getBasePath()));
		foreach ($liveClassroomList as $key=>$classroom){
			
			
			$school_name = (isset($schoolInfoList[$classroom['school_id']]))?$schoolInfoList[$classroom['school_id']]:'未知学校名';
			$realname = (isset($userInfoList[$classroom['teacher_id']]['realname']))?$userInfoList[$classroom['teacher_id']]['realname']:'未知教师名称';
			$subject_name = (isset($subjectInfoList[$classroom['subject_id']]))?$subjectInfoList[$classroom['subject_id']]:'未知学科名称';
			
			$photo = (isset($userInfoList[$classroom['teacher_id']]['photo']))?$userInfoList[$classroom['teacher_id']]['photo']:'';
				
			if ($photo != ''){
				$picPath = $classroom['teacher_id'].'/photo/'.$photo;
			}else{
				$picPath = 'default/photo/defaultface.png';
			}
			$photoUrl =  sprintf("%s/%s/%s",$basePath,'media/user',$picPath);
			
			$liveClassroomList[$key]['school_name'] = $school_name;
			$liveClassroomList[$key]['teacher_name'] = $realname;
			$liveClassroomList[$key]['subject_name'] = $subject_name;
			$liveClassroomList[$key]['photo'] = $photoUrl;
			$liveClassroomList[$key]['url'] = $controller->url()->fromRoute('common',array('controller'=>'liveclassroom','action'=>'join','id'=>$classroom['id']));
			
		}
		
		//更多的链接
		
		
		$more = $controller->url()->fromRoute('common',array('controller'=>'liveclassroom','action'=>'list'));
		
		
		//4.填装数据
																					
		$data['classroomList'] 			 	= $liveClassroomList;
		
		$data['title']			 = $title;
		
		$data['more']			 = $more;
		
		
		return $data;
		
	}//function formatData() end
	
	
	/**
	 * 用来检验内容组件的内容参数是否符合要求
	 */
	
	private function checkContentConfigParameter($controller,$contentConfig){
		
		$modelList = array('userModel','subjectModel','liveClassroomModel');
		
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
		$PhpRenderer->headLink()->appendStylesheet($basePath.'/theme/website/common/Cms/liveClassroom/live_lesson.css');
		
		$viewModel = new ViewModel();
		$viewModel->setTemplate('Component/liveClassRoom/Common/template');
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