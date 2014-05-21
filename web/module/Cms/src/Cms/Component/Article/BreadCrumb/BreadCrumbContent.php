<?php

namespace Cms\Component\Article\BreadCrumb;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


abstract class BreadCrumbContent extends BaseComponent implements ComponentInterface{
	
	protected $categoryId   = null;//栏目的ID
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	
	/**
	 * 设置栏目要读取哪个分类之下的文章
	 * @param $categoryId 
	 */
	public function setCategoryId($id){
		$this->categoryId = $id;
		return $this;
	}//function setCategoryId() end
	
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//第一步:查询文章分类相关信息
		if(is_null($this->categoryId)){
			return;//如果分类ID为空的前提下，直接return
		}
		
		$articleSortModel = $this->serviceManager->get('Cms\Component\Article\Column\Model\ArticleSort');
		
		$ancestorCategoryList = $articleSortModel->getAncestorRowListById($this->categoryId,array('id','name','parent_id'));
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
		
		$this->setVariable('categoryList', $ancestorCategoryList);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



