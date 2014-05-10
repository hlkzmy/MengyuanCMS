<?php

namespace School\Controller;



use Zend\Db\Sql\Where;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

use Zend\View\Model\ViewModel;
use Base\Controller\BaseController;



class SchoolController extends BaseController{

	
	public function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','SchoolModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','SchoolSortModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','AreaModel');
		
		//注册过滤器对象
		$this->registFilter($this->serviceManager, 'AreaFilter');
		$this->registFilter($this->serviceManager, 'SchoolFilter');
		
	
		//注册表单对象
		$this->registForm($this->serviceManager, 'Information', 'School', 'SchoolForm');
		
	}//function __construct() end
	
	
	public function getAreaIdLookupHref(){
	
		$routeParam = array(
				'controller'=>'school',
				'action'=>'lookup',
				'source'=>'information.school.create',
				'name'=>'area_id'
		);
		
		$url =  $this->url()->fromRoute('information',$routeParam);
			
		return $url;
	}//function getParentIdLookupString() end
	
	
	public function getAreaIdLookupPostUrl(){
		 
		$url =  $this->url()->fromRoute('information',array('controller'=>'school','action'=>'append'));
		 
		return $url;
		 
	}//function getVideoSortIdLookupPostUrl() end
	
	
	public function getSchoolId($insertData)
	{
		$area_id = $insertData['area_id'];
		
		$where = new Where();
		$where->equalTo('parent_id', $area_id);
		
		$exp = new Expression();
		$exp->setExpression("max(`id`)");
		
		$columns = array('id'=>$exp,'level');
		
		$max_area_id = $this->areaModel->getRowByCondition($where,$columns);
		
		$level = $max_area_id[0]['level'];
		$max_area_id = $max_area_id[0]['id'];
		
		if (is_null($max_area_id)){
			return $area_id.'001';
		}
		
		if($level !== 5){
			$this->ajaxReturn(300, '只能选择市一级的地区');
		}
		
		return $max_area_id+1;
		
	}
	
	public function getFullName($data)
	{
		
		if (isset($data['id'])){
			
			$row = $this->areaModel->getRowById($data['id'],array('id','parent_id'));
			
			$parent_id = $row['parent_id'];
			
			$parent = $this->areaModel->getRowById($parent_id,array('id','full_name'));
			
		}else{
			$parent_id = $data['parent_id'];
			
			$parent = $this->areaModel->getRowById($parent_id,array('id','full_name'));
		}
		
		$fullname = $parent['full_name'].' '.$data['name'];
		
		return $fullname;
	}
	

}//function SchoolController
