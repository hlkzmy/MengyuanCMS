<?php

namespace Courseware\Controller;


use Zend\View\Model\ViewModel;
use Base\Controller\BaseController;




class CoursewareController extends BaseController
{
   
	public function __construct(){
   	
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','CoursewareModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','CoursewareSortModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoSortModel');
		
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Courseware','CoursewareForm');
		
		//注册filer对象
		
		$this->registFilter($this->serviceManager, 'CourswareFilter');
		
   }//function __construct() end
	
	
	public function getCoursewareSortIdLookupHref()
	{
		
		 $routeParam = array(
   							'controller'=>'courseware',
   							'action'=>'lookup',
   							'source'=>'resource.courseware.create',
   							'name'=>'courseware_sort_id'
   					      );
   	    
   		$url =  $this->url()->fromRoute('resource',$routeParam);
   	 
   		return $url;
		
	}
	
	public function getVideoIdLookupHref()
	{
	
		$routeParam = array(
				'controller'=>'courseware',
				'action'=>'lookup',
				'source'=>'resource.courseware.create',
				'name'=>'video_id'
		);
	
		$url =  $this->url()->fromRoute('resource',$routeParam);
		 
		return $url;
	
	}
	
	
	
	public function getCoursewareSortIdLookupPostUrl(){
		 
		$url =  $this->url()->fromRoute('resource',array('controller'=>'courseware','action'=>'append'));
		 
		return $url;
		 
	}//function getVideoSortIdLookupPostUrl() end
   
	public function getFileName($file)
	{
		$oldname = $file['name'];
		
		$ext = strrchr($oldname, '.');
		
		$newname = md5($oldname.time()).$ext;
		
		return $newname;
	}

   
}//class CoursewareController() end
