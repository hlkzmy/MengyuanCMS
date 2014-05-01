<?php
namespace Article\Controller;

use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;


class ArticleSortController extends BaseController
{
	
	
	public function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		$this->registDatabaseModel($this->serviceManager,'Base','Model','ArticleSortModel');
	
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Article','ArticleSortForm');
		
		//注册filter对象
		$this->registFilter($this->serviceManager, 'ArticleSortFilter');
		
	}//function __construct() end
	
	
	public function getArticleSortLookupString(){
		 
		$url =  $this->url()->fromRoute('resource',array('controller'=>'articleSort','action'=>'read'));
		 
		return $url;
	}//function getLookupString() end
	
	public function getArticleSortListPostUrl(){
	
		$url =  $this->url()->fromRoute('resource',array('controller'=>'articleSort','action'=>'append'));
			
		return $url;
	
	}//function getVideoSortListPostUrl() end

	
	public function getParentIdLookupHref()
	{
		 
		$routeParam = array(
				'controller'=>'articleSort',
				'action'=>'lookup',
				'source'=>'resource.articlesort.create',
				'name'=>'parent_id'
		);
		 
		$url =  $this->url()->fromRoute('resource',$routeParam);
		 
		return $url;
		 
	}
	
   public function getArticleSortIdLookupPostUrl(){
   		
   		$url =  $this->url()->fromRoute('resource',array('controller'=>'articleSort','action'=>'append'));
   		
   		return $url;
   		
   }
   
   
   
}//class ArticleSortController end
