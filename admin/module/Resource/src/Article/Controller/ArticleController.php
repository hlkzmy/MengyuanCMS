<?php

namespace Article\Controller;


use Zend\Mvc\View\Console\ViewManager;

use Zend\View\Model\ViewModel;
use Base\Controller\BaseController;
use Zend\Authentication\AuthenticationService as AuthenticationService;


class ArticleController extends BaseController
{
   
	public function __construct(){
   	
		parent::__construct();
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','ArticleModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','ArticleSortModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','ArticleContentModel');
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','UserModel');
		
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Article','ArticleForm');
		
		//注册filer对象
		$this->registFilter($this->serviceManager, 'ArticleFilter');
		
		$this->registFilter($this->serviceManager, 'ArticleContentFilter');
		
   }//function __construct() end
	
   
   public function getArticleContentUpLinkUrlString(){
   	
   		$url = $this->url()->fromRoute('resource',array('controller'=>'article','action'=>'upload'));
   	
   		return $url;
   }
   
   public function getArticleContentUpImgUrlString(){
   	
   		$url = $this->url()->fromRoute('resource',array('controller'=>'article','action'=>'upload'));
   	
   		return $url;
   	
   }
   public function getArticleSortIdLookupPostUrl(){
   		
   		$url =  $this->url()->fromRoute('resource',array('controller'=>'article','action'=>'append'));
   		
   		return $url;
   		
   }
   
   public function getArticleSortLookupHref()
   {
   
   		$routeParam = array(
   			'controller'=>'article',
   			'action'=>'lookup',
   			'source'=>'resource.article.create',
   			'name'=>'article_sort_id'
   		);
   
   		$url =  $this->url()->fromRoute('resource',$routeParam);
   	 
   		return $url;
   
   }
	
   public function getLoginUserId()
   {
   		$auth = new AuthenticationService();
    	$user = $auth->getIdentity();
    	
    	if (!$auth->hasIdentity()){
    		throw new \Exception('抱歉，你没有登录');
    	}
    	
   		return $user->id;
   }
   
}//class ArticleController() end
