<?php

namespace Etah\Cms\Component\Comment\ChatRoom;

use Zend\Http\Client;

use Etah\Mvc\Controller\BaseController as EtahMvcBaseController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;
use Zend\Authentication\AuthenticationService as AuthenticationService;

class Content extends EtahMvcBaseController{
	
	
	function __construct(){
		parent::__construct();
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','SchoolModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoCommentModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','PageModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','ContainerModel');
	}//function __construct() end
	
	/**
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
		$limit = 4;
		
		$videoId = $this->getRequest()->getPost('video_id');
		
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
		
		$commentPaginator = $controller->videoCommentModel->getFilterRowList($commentColumns,$where,$order);
		
		$commentPaginator->setCurrentPageNumber((int)$controller->params()->fromPost('currentPageNumber', 1));
		
		$commentPaginator->setItemCountPerPage($limit);
		
		$commentPaginator->setPageRange(6);
		
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
			
			$userTempList = $controller->userModel->getRowById($userId,array('id','realname','photo','school_id'));
			
			foreach ($userTempList as $user){
				$schoolIdList[$user['id']] = $user['school_id'];
			}
			
			$schoolTempList = $this->schoolModel->getRowById($schoolIdList,array('id','name'));
			foreach ($schoolTempList as $s){
				$schoolList[$s['id']] = $s['name'];
			}
			
			foreach ($userTempList as $key=>$user){
				
				$userList[$user['id']] = array(
						
						'realname'=>$user['realname'],
						'photo'=>$user['photo'],
						'school_name'=>$schoolList[$user['school_id']]
						);
				
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
			$commentList[$key]['user_info']['user_name'] = $userList[$comment['user_id']]['school_name'].$userList[$comment['user_id']]['realname'].'老师';
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
		$html =  $this->render($this,null);
		
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
					'status'=>300,
					'info'=>'您还没有登录，不能发表评论',
			);
			exit(json_encode($data));
		}
		 
		$user = $auth->getIdentity();
		 
		$userId = $user->id;
		 
		$videoId = $this->getEvent()->getRouteMatch()->getParam('id');
		 
		$data = $request->getPost()->ToArray();

		date_default_timezone_set('Asia/Shanghai');
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
					'status'=>300,
					'info'=>$info,
			);
			exit(json_encode($data));
		}
		 
		if ($commentConfig['comment_need_verify'])
		{
			$info = '发表成功，请等待后台审核';
		}else{
			$info = '发表成功';
		}
		 
		 
		$data = array(
				'status'=>200,
				'info'  =>$info,
		);
	
		exit(json_encode($data));
		 
	}
	
	public function render($controller,$contentConfig){
		
		$data = $this->getDataByParseContentConfig($controller,$contentConfig);
		
		$viewModel = new ViewModel();
			
		$viewModel->setTemplate('Component/Comment/ChatRoom/template');
			
		$viewModel->setVariable('data', $data);
		
		$viewModel->setTerminal(true);
			
		return $viewModel;
	}//function renderTemplate() end
	
	
	
	
	
	
	
}//class Common end