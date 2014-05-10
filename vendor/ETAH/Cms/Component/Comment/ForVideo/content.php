<?php

namespace Etah\Cms\Component\Comment\Forvideo;

use Zend\Http\Client;

use Etah\Mvc\Controller\BaseController as EtahMvcBaseController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;
use Zend\Authentication\AuthenticationService as AuthenticationService;

class Content extends EtahMvcBaseController{
	
	
	function __construct(){
		parent::__construct();
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoCommentModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','PageModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','ContainerModel');
	}//function __construct() end
	
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
	 * 3.形成配置界面的php文件通过类似于生成添加对象的界面返回给后台的都是一个post的数组，只不过 Create界面需要有参数解析然后选择进行各种操作的checkCreate
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
		
		//第二步：解析内容,每个内容组件这部分都不一样
		
		//1.取得评论列表
		
		$postData = $controller->getRequest()->getPost()->toArray();
		$limit = $contentConfig['limit'];
		
		$videoId = $controller->getEvent()->getRouteMatch()->getParam('id');
		
		$where = new Where();
		$where->equalTo('video_id', $videoId);
		$where->equalTo('status', 'Y');
		
		$commentColumns = array(
				'id',
				'user_id',
				'video_id',
				'content',
				'add_time'
				);
		
		$order = array(
				'add_time'=>'DESC'
				);
		
		
		
		//取得查询列表的偏移量
		if(!isset($postData['currentPageNumber'])){
			$currentPageNumber = 1;
		}
		else{
			$currentPageNumber = $postData['currentPageNumber'];
		}
		
		
		$commentPaginator = $controller->videoCommentModel->getFilterRowList($commentColumns,$where,$order);
		
		$commentPaginator->setCurrentPageNumber($currentPageNumber);
		
		$commentPaginator->setItemCountPerPage($limit);
		
		$commentList = array();
		$userId = array();
		$userList = array();
		
		//2.取得用户数据
		foreach ($commentPaginator as $key=>$comment)
		{
			$commentList[$key] = $comment;
			array_push($userId, $comment['user_id']);
		}
		
		$userId = array_unique($userId);
		
		if (sizeof($userId) > 0){
			
			$userTempList = $controller->userModel->getRowById($userId,array('id','realname','photo'));
			
			foreach ($userTempList as $user){
					
				$userList[$user['id']] = array('realname'=>$user['realname'],'photo'=>$user['photo']);
			}
		}


		
		//3.对返回的数据进行处理，返回长长的url
		$basePath = dirname(dirname($controller->getRequest()->getBasePath()));
		foreach ($commentList as $key=>$comment)
		{
			if ($userList[$comment['user_id']]['photo'] != ''){
				$picPath = $comment['user_id'].'/photo/'.$userList[$comment['user_id']]['photo'];
			}else{
				$picPath = 'default/photo/defaultface.jpg';
			}
			$commentList[$key]['user_info']['user_name'] = $userList[$comment['user_id']]['realname'];
			$commentList[$key]['user_info']['user_pic'] =  sprintf("%s/%s/%s",$basePath,'media/user',$picPath);
		}
		//4.填装数据
																					
		$data['commentList']		= $commentList;
		$data['commentPaginator']   = $commentPaginator;
		
		$data['video_id'] = $videoId;
		
		return $data;
		
	}//function formatData() end
	
	
	/**
	 * 用来检验内容组件的内容参数是否符合要求
	 */
	
	private function checkContentConfigParameter($controller,$contentConfig){
		
		$modelList = array('videoCommentModel');
		
		foreach($modelList as $model){
			if(!isset($controller->{$model})){
				die(  sprintf('形成内容组件所需要的数据表%s在当前调用内容组件的控制器没有完成初始化',$model));
			}
		}
		
	}//function checkContentConfig() end
	
	public function AjaxGetCommentListAction()
	{
		$html = $this->AjaxrefreshCommentList();
		 
		exit($html);
	}
	 
	 
	private function AjaxrefreshCommentList()
	{
	
		
		$referer = $this->getRequest()->getHeaders()->get('Referer');
		
		$refererPath = $referer->uri()->toString();
		
		$basePath = $this->getRequest()->getbasePath();
		
		$refererPath = strstr($refererPath,$basePath);
		
		$offset = strlen($basePath);
		
		$refererPath = substr($refererPath,$offset+1,strlen($refererPath));
		
		$routeParameter = explode('/',$refererPath); 
		
		$where = new Where();
		$where->equalTo('namespace', $routeParameter[0]);
		$where->equalTo('controller',$routeParameter[1]);
		$where->equalTo('action', 	 $routeParameter[2]);
		 
		$pageColumns = array('id','name','setting');
		 
		$pageInfo    = $this->pageModel->getRowByCondition($where,$pageColumns);
	
		if(sizeof($pageInfo)==0){
			 
			$message = sprintf('没有在关于页面配置的数据表中找到%s相应的页面，请联系网站管理员！',implode('->',$routeParameter));
			 
			die($message);
		}
		 
		$pageInfo    = $pageInfo[0];
	
		$where = new Where();
		$where->equalTo('page_id', $pageInfo['id']);
		$where->equalTo('name', 'record-video-comment');
	
		$container = $this->containerModel->getRowByCondition($where);
	
		$container = array_pop($container);
	
		
		$data = $this->getDataByParseContentConfig($this,$container['content']);
		
		$phpRenderer = $this->serviceManager->get ( 'Zend\View\Renderer\PhpRenderer' );
		
		//加载所需要的js
		$basePath = $this->getRequest()->getBasePath();
		$phpRenderer->headScript()->appendFile($basePath.'/js/cms/component/videoComment.js');
		// 		$PhpRenderer->headScript()->appendFile($basePath.'/js/cms/component/page.js');
		
		$viewModel = new ViewModel();
		
		$viewModel->setVariable('data', $data);
		$viewModel->setTemplate('Component/Comment/ForVideo/comment');
		
		$html = $phpRenderer->render($viewModel);
		
		return $html;
	
	}
	 
	 
	public function AjaxSubmitCommentAction()
	{
		$request = $this->getRequest();
		 
		if (!$request->isXmlHttpRequest()){
			die('请勿非法操作');
		}
		 
		$auth = new AuthenticationService();
		 
		if (!$auth->hasIdentity()){
	
			$data = array(
					'status'=>'0',
					'info'=>'您还没有登录，不能发表评论',
			);
			exit(json_encode($data));
	
	
		}
		 
		$user = $auth->getIdentity();
		 
		$userId = $user->id;
		 
		$videoId = $this->getEvent()->getRouteMatch()->getParam('id');
		 
		$data = $request->getPost()->ToArray();
		 
		$data['add_time'] = date('Y-m-d H:i:s');
		$data['user_id'] = $userId;
		$data['video_id'] = $videoId;
		 
		$commentConfig = $this->serviceManager->get('config');
		 
		if ($commentConfig['comment_need_verify'])
		{
			$data['status'] = 'U';
		}else{
			$data['status'] = 'Y';
		}
		 
		try {
	
			$this->videoCommentModel->insertRow($data);
	
		}catch ( \Exception $e){
	
			$info = $e->getMessage();
	
			$data = array(
					'status'=>'0',
					'info'=>$info,
			);
			exit(json_encode($data));
		}
		 
		$html = $this->AjaxrefreshCommentList();
		 
		if ($commentConfig['comment_need_verify'])
		{
			$info = '发表成功，请等待后台审核';
		}else{
			$info = '发表成功';
		}
		 
		 
		$data = array(
				'status'=>'1',
				'info'  =>$info,
				'data'=>$html
		);
	
		exit(json_encode($data));
		 
	}
	
	public function render($controller,$contentConfig){
		
		
		$videoId = $controller->getEvent()->getRouteMatch()->getParam('id');
		
		$phpRenderer = $this->serviceManager->get ( 'Zend\View\Renderer\PhpRenderer' );
		
		//加载所需要的js
		$basePath = $controller->getRequest()->getBasePath();
		$phpRenderer->headScript()->appendFile($basePath.'/js/cms/component/videoComment.js');
		
		$viewModel = new ViewModel();
		
		$viewModel->setTemplate('Component/Comment/ForVideo/template');
		$viewModel->setVariable('video_id', $videoId);
		
		$html = $phpRenderer->render($viewModel);
			
		
		return $html;
	}//function renderTemplate() end
	
	
	
	
	
	
	
}//class Common end