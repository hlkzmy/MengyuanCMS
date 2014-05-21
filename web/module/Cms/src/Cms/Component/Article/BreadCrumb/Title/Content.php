<?php

namespace Cms\Component\Article\BreadCrumb\Title;
use Cms\Component\Article\BreadCrumb\BreadCrumbContent;
use Cms\Component\ComponentInterface;


class Content extends BreadCrumbContent implements ComponentInterface{
	
	protected $articleId   = null;//栏目的ID
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		
	}//function __construct() end
	
	
	public function setArticleId($id){
		$this->articleId = $id;
		return $this;
	}
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//第一步:查询文章分类相关信息
		if(is_null($this->articleId)){
			return;//如果文章ID为空的前提下，直接return
		}
		
		$articleModel     = $this->serviceManager->get('Cms\Component\Article\Breadcrumb\Title\Model\Article');
		$articleCategoryModel = $this->serviceManager->get('Cms\Component\Article\Breadcrumb\Title\Model\ArticleSort');
		
		$article = $articleModel->getRowById($this->articleId);
		if(sizeof($article)==0){
			return;//如果文章内容为空的前提下，直接return
		}
		
		$articleCategoryId = $article['article_sort_id'];
		
		
		$ancestorCategoryList = $articleCategoryModel->getAncestorRowListById($articleCategoryId,array('id','name','parent_id'));
		if(sizeof($ancestorCategoryList)==0){
			return;//如果分类ID为空的前提下，直接return
		}
		
		
		//第二步:渲染视图模版，添加css和js的路径
		$phpRenderer 		= $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		$cssPath = $basePathViewHelper( sprintf("component/article/bread-crumb/style%s/images/component.css",$this->styleNumber));
		$phpRenderer->headLink()->appendStylesheet($cssPath);
		
		
		//第三步：对于查询的结果做一些处理
		//1.对文章标题的url做操作
		$url = $this->serviceManager->get('Controller\Plugin\Manager')->get('url');

		foreach($ancestorCategoryList as $key=>$element){
				
			if($element['parent_id']==0&&!$this->showRootNode){
				unset($ancestorCategoryList[$key]);
				continue;
			}
			
			$ancestorCategoryList[$key]['href'] = $url->fromRoute('article-category-route',array('id'=>$element['id']));
		}
		
		//2.添加首页的链接
		$ancestorCategoryList = array_merge(array(array('name'=>'首页','href'=>'/')),$ancestorCategoryList);

		
		//3.添加当前文章页的链接
		array_push($ancestorCategoryList,array('name'=>$article['title'],'href'=>'javascript:;'));
		
		$this->setVariable('categoryList', $ancestorCategoryList);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



