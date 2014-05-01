<?php

namespace Comment\Controller;


use Zend\View\Model\ViewModel;
use Base\Controller\BaseController;




class VideoCommentController extends BaseController
{
   
	public function __construct(){
   	
		parent::__construct();
		
		//注册数据表对象
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoCommentModel');
		//注册表单对象
// 		$this->registForm($this->serviceManager,'Resource','Comment','VideoCommentForm');
		
		//注册filer对象
		
// 		$this->registFilter($this->serviceManager, 'VideoCommentFilter');
		
   }//function __construct() end
	
	public function getStatusString($postData)
	{
		switch ($postData['status']){
			case 'Y':$postData['status_string'] = '已审核';break;
			case 'U':$postData['status_string'] = '未审核';break;
			case 'N':$postData['status_string'] = '已删除';break;
		}

		return $postData['status_string'];
		
	}
	/**
	 * 批量审核
	 */
	
	public function checkAction()
	{
		$request = $this->getRequest();
		
		if(!$request->isXmlHttpRequest()){
			die('请不要尝试非法操作，谢谢您的合作！');
		}
		
		$postData    = $request->getPost()->toArray();
		
		$commentIdList = $postData['ids'];
		
		
		//此处开启数据事务
		$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction();
		
		 
		try{
			$this->videoCommentModel->updateRowById($commentIdList,array('status'=>'Y'));
		}
		catch (\Exception $e ) {
		
			$dbConnection->rollback();
			$this->ajaxReturn( '300', $e->getMessage () );
		}
		 
		 
		$dbConnection->commit ();
		$this->ajaxReturn ('200','恭喜您，批量审核成功！');
	}
	/**
	 * 批量删除
	 * @see \Etah\Mvc\Controller\BaseController::deleteAction()
	 */
	public function deleteAction()	
	{
		$request = $this->getRequest();
	
		if(!$request->isXmlHttpRequest()){
			die('请不要尝试非法操作，谢谢您的合作！');
		}
	
		$postData    = $request->getPost()->toArray();
	
		$commentIdList = $postData['ids'];
	
	
		//此处开启数据事务
		$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction();
	
			
		try{
			$this->videoCommentModel->updateRowById($commentIdList,array('status'=>'N'));
		}
		catch (\Exception $e ) {
	
			$dbConnection->rollback();
			$this->ajaxReturn( '300', $e->getMessage () );
		}
			
			
		$dbConnection->commit ();
		$this->ajaxReturn ('200','批量删除成功！');
	}

   
}//class CoursewareController() end
