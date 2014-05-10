<?php

namespace User\Controller;

use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Etah\Common\GaugeTemplate\GaugeTemplate;

class UserController extends BaseController {
	
	
	function __construct() {
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'UserModel');
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'AreaModel');
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'SchoolModel');
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'SubjectModel');
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'WorkTypeModel');
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'RoleModel');
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'UserRoleModel');
		
		//注册表单对象
		$this->registForm($this->serviceManager, 'Information', 'User', 'UserForm');
		
		
		//注册验证器对象
		$this->registFilter($this->serviceManager, 'UserFilter');
		
		$this->registFilter($this->serviceManager, 'UserRoleFilter');
	}
	
	public function getpassword($data)
	{
		
		if (empty($data['password'])){
			$this->ajaxReturn('300', '密码不能为空');
		}
		
		if ($data['password'] == $data['confirm_password']){
			
		}else{
			
			$this->ajaxReturn('300', '两次输入的密码不相同');
		}
		
		return $data;
		
	}
	
	public function checkSchool($postData)
	{
		if (isset($postData['school_school_id']) && is_numeric($postData['school_school_id'])){
			$areaInfo = $this->areaModel->getRowById($postData['school_school_id'],array('level'));
		}else{
			$this->ajaxReturn('300', '请填写用户所属的学校');
		}
		
		if (!isset($areaInfo['level']) || $areaInfo['level'] != 5){
			$this->ajaxReturn('300', '选择用户所属学校时，请选择到学校级别');
		}
		
		return $postData;
		
	}
	
	
	public function testAction()
	{
		
		$aaa = new GaugeTemplate();
		
		$aaa->ReturnCurrentActiveSheet('D:\test.xlsx');
		
		print_r($aaa);exit;
		
		
	}
		
	public function getSchoolIdLookupHref(){
	
		$routeParam = array(
				'controller'=>'user',
				'action'=>'lookup',
				'source'=>'information.user.create',
				'name'=>'school_id'
		);
	
		$url =  $this->url()->fromRoute('information',$routeParam);
		 
		return $url;
		 
	}//function getAreaIdLookupString() end
	 
	public function getSchoolIdLookupPostUrl(){
		 
		$url =  $this->url()->fromRoute('information',array('controller'=>'user','action'=>'append'));
		 
		return $url;
		 
	}//function getVideoSortIdLookupPostUrl() end
	

}//class UserController() end
