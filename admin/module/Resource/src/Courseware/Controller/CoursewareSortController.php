<?php
namespace Courseware\Controller;

use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;


class CoursewareSortController extends BaseController
{
	public function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','CoursewareSortModel');
	
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Courseware','CoursewareSortForm');
		
		//注册过滤对象
		$this->registFilter($this->serviceManager, 'CourswareSortFilter');
	}//function __construct() end
	
	
	public function getCoursewareSortListPostUrl(){
	
		$url =  $this->url()->fromRoute('resource',array('controller'=>'coursewareSort','action'=>'append'));
			
		return $url;
	
	}//function getVideoSortListPostUrl() end
	
	
	public function getParentIdLookupHref(){
	
		$routeParam = array(
				'controller'=>'coursewareSort',
				'action'=>'lookup',
				'source'=>'resource.coursewaresort.create',
				'name'=>'parent_id'
		);
	
		$url =  $this->url()->fromRoute('resource',$routeParam);
	
		return $url;
	
	}//function getLookupString() end

	public function getParentIdLookupPostUrl(){
		
		$url =  $this->url()->fromRoute('resource',array('controller'=>'coursewareSort','action'=>'append'));
			
		return $url;
	}
	
	
    
}//class CoursewareSortController end
