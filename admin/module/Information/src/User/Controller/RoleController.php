<?php
namespace User\Controller;

use Base\Controller\BaseController;
use Base\Factory\ServiceLocatorFactory;
use Base\Filter\RoleFilter;

use Zend\Authentication\Storage\Chain;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;


class RoleController extends BaseController
{
	function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'RoleModel' );
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'UserRoleModel');
		
		//注册表单对象
		$this->registForm($this->serviceManager, 'Information', 'Role', 'RoleForm');
		
		//注册验证器对象
		$this->registFilter($this->serviceManager, 'RoleFilter');
		
	}//function __construct() end
	
	
	public function getParentIdLookupHref(){
	
		$routeParam = array(
				'controller'=>'role',
				'action'=>'lookup',
				'source'=>'information.role.create',
				'name'=>'parent_id'
		);
	
		$url =  $this->url()->fromRoute('information',$routeParam);
	
		return $url;
	
	}//function getLookupString() end
	
	public function getParentIdLookupPostUrl(){
	
		$url =  $this->url()->fromRoute('information',array('controller'=>'role','action'=>'append'));
	
		return $url;
	
	}//function getLookupString() end
	
	public function getRoleListPostUrl(){
		
		$url =  $this->url()->fromRoute('information',array('controller'=>'role','action'=>'append'));
			
		return $url;
		
	}//function getParentIdLookupString() end
		
	
	
	
	
	
}//class  RoleController() end

