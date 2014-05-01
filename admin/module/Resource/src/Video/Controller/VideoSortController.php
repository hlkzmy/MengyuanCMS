<?php
namespace Video\Controller;

use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;


class VideoSortController extends BaseController
{
	
	public function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoSortModel');
	
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Video','VideoSortForm');
		
		//注册Filter对象
		$this->registFilter($this->serviceManager, 'VideoSortFilter');
		
	}//function __construct() end
	
	
	public function getParentIdLookupHref(){
	
		$routeParam = array(
				'controller'=>'videoSort',
				'action'=>'lookup',
				'source'=>'resource.videosort.create',
				'name'=>'parent_id'
		);
		
		$url =  $this->url()->fromRoute('resource',$routeParam);
		
		return $url;
		
	}//function getLookupString() end
	
	public function getParentIdLookupPostUrl(){
	
		$url =  $this->url()->fromRoute('resource',array('controller'=>'videoSort','action'=>'append'));
		
		return $url;
	
	}//function getLookupString() end
	
	
	public function getVideoSortListPostUrl(){
	
		$url =  $this->url()->fromRoute('resource',array('controller'=>'videoSort','action'=>'append'));
		 
		return $url;
	
	}//function getVideoSortListPostUrl() end
	
	
	
	
    
}//class VideoSortController end
