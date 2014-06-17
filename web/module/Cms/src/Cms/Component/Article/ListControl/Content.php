<?php

namespace Cms\Component\Article\ListControl;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;

use Zend\Mvc\Controller\Plugin\Params;//用来在控制器中设定


class Content extends BaseComponent implements ComponentInterface{
	
	protected $categoryId   = null;//栏目的ID
	
	protected $articleTitleLength = 10;//设置文章标题的长度
	
	protected $articleTitleWithDate = false;//文章标题
	
	protected $params = null;
	
	protected $useGlobalPaginationConfig = false;//是否使用全局的翻页配置
	
	protected $itemCountPerPage = 10;//每页的条数
	
	protected $pageRange = 10;//换页的页面的总数
	
	protected $requestUri = null;
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplateStyle(1);
		$this->setScrollingStyle('sliding');
		$this->setPartial('ajax-paginator');
	}//function __construct() end
	
	
	public function setRequestUri($uri){
		$this->requestUri = $uri;
		return $this;
	}//function setRequestUri();
	

	
	public function setItemCountPerPage($count){
		$this->itemCountPerPage = $count;
		return $this;
	}
	
	public function setPageRange($count){
		$this->pageRange = $count;
		return $this;
	}
	
	
	/**
	 * 在控制器中调用，把http的参数设置给当前的变量
	 */
	public function setParams(Params $params){
		$this->params = $params;
		return $this;
	}//function setParams() end
	
	private function getParam(){
		return $this->params;
	}
	
	
	/**
	 * 设置栏目要读取哪个分类之下的文章
	 * @param $categoryId 
	 */
	public function setCategoryId($id){
		$this->categoryId = $id;
		return $this;
	}//function setCategoryId() end
	
	
	/**
	 * 设置文章标题的长度，裁切长度
	 * @param int $length
	 * @return \Cms\Component\Article\Column\Content
	 */
	public function setArticleTitleLength($length){
		$this->articleTitleLength = $length;
		return $this;
	}
	
	
	/**
	 * 设置显示栏目标题的时候是否显示日期
	 */
	public function setArticleTitleWithDate($status){
		$this->articleTitleWithDate = $status;
		$this->setVariable('articleTitleWithDate', $status);
		return $this;
	}
	
	/**
	 * 设置换页的样式
	 * @param string $style
	 */
	public function setScrollingStyle($style){
		$this->setVariable('scrollingStyle', $style);
	}
	
	/**
	 * 设置换页的模版
	 * @param string $template
	 */
	public function setPartial($template){
		$templatePath = sprintf('%s/Template/%s',__NAMESPACE__,$template);
		$templatePath = str_replace("\\",'/',$templatePath);
		$this->setVariable('partial', $templatePath);
	}
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//第一步:查询文章分类相关信息
		if(is_null($this->categoryId)){
			return;//如果分类ID为空的前提下，直接return
		}
		
		$articleModel 		= $this->serviceManager->get('Cms\Component\Article\ListControl\Model\Article');
		$articleSortModel 	= $this->serviceManager->get('Cms\Component\Article\ListControl\Model\ArticleSort');
		
		//得到所有子孙分类的列表
		$childrenCategoryList = $articleSortModel->getDescendantRowListById($this->categoryId);
		if(sizeof($childrenCategoryList)==0){
			return;//如果查询的包含自身分类 和 子分类,那么直接return
		}
		
		$childrenCategoryIdList = array();
		
		foreach($childrenCategoryList as $category){
			array_push($childrenCategoryIdList,$category['id']);
		}
		
		$column = array('id','title');
		if($this->articleTitleWithDate){
			$column['date'] = 'add_time';
		}
		
		//第二步:渲染视图模版，添加css和js的路径
		$phpRenderer 		= $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		$cssPath = $basePathViewHelper( sprintf("component/article/list-control/style%s/images/component.css",$this->styleNumber));
		$phpRenderer->headLink()->appendStylesheet($cssPath);
		
		
		//第三步:得到换页的对象
		$postData = $this->params->fromPost();
		if(isset($postData['currentPageNumber'])){
			$currentPageNumber = $postData['currentPageNumber'];
		}
		else{
			$currentPageNumber = 1;
		}
		
		$paginator = $articleModel->getPaginator($childrenCategoryIdList,$column);
		$paginator->setCurrentPageNumber($currentPageNumber);
		if($this->useGlobalPaginationConfig){//如果使用全局的换页配置的话
			$config = $this->serviceManager->get('config');
			
			
		}
		else{
			$paginator->setItemCountPerPage($this->itemCountPerPage);
			$paginator->setPageRange($this->pageRange);
		}
		
		//第四步：
		if(true){//如果是ajax的换页方法
			
			$paginatorForm = $this->serviceManager->get('Cms\Component\Article\ListControl\Form\PaginatorForm');
			$paginatorForm->setAttribute('action',$this->requestUri);
			$paginatorForm->get('currentPageNumber')->setValue($currentPageNumber);
			
			$this->setVariable('paginatorForm', $paginatorForm);
		}
		else{
			
			
		}
		
		
		//第三步：对于查询的结果做一些处理
		//1.对文章标题的url做操作
		$url = $this->serviceManager->get('Controller\Plugin\Manager')->get('url');
		
		$articleList = array();
		
		foreach($paginator as $element){
			
			$element['href'] = $url->fromRoute('article-content-route',array('id'=>$element['id']));
			
 			if($this->articleTitleWithDate){
 				$element['date'] = substr($element['date'],0,10);
			}
			
			$element['title'] = mb_substr($element['title'],0,$this->articleTitleLength,'utf-8');
			
			array_push($articleList,$element);
		}
		
		$this->setVariable('articleList', $articleList);
		$this->setVariable('paginator', $paginator);
		
		if($returnType=='html'){
			return $phpRenderer->render($this);
		}
		
	}//function render() end
	
	
}//class end



