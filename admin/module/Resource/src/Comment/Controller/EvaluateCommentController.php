<?php
namespace Comment\Controller;

use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;


class EvaluateCommentController extends BaseController
{
	public function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','EvaluationCommentModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','EvaluationModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
	
		//注册表单对象
// 		$this->registForm($this->serviceManager,'Resource','Comment','EvaluateCommentForm');
		
		//注册过滤对象
// 		$this->registFilter($this->serviceManager, 'EvaluateCommentFilter');
	}//function __construct() end
	
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
			$this->evaluationCommentModel->deleteRowById($commentIdList,array('status'=>'N'));
		}
		catch (\Exception $e ) {
	
			$dbConnection->rollback();
			$this->ajaxReturn( '300', $e->getMessage () );
		}
			
			
		$dbConnection->commit ();
		$this->ajaxReturn ('200','批量删除成功！');
	}
    
}//class CoursewareSortController end
