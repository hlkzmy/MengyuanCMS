<?php

namespace Cms\Component\Article\Sidebar\Title;
use Cms\Component\Article\Sidebar\SidebarContent;
use Cms\Component\ComponentInterface;
use Zend\Db\Sql\Where;


class Content extends SidebarContent implements ComponentInterface{
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//第一步:查询文章分类相关信息
		if(is_null($this->categoryId)){
			return;//如果分类ID为空的前提下，直接return
		}
		
		$articleModel 		  = $this->serviceManager->get('Cms\Component\Article\Sidebar\Title\Model\Article');
		$articleCategoryModel = $this->serviceManager->get('Cms\Component\Article\Sidebar\Title\Model\ArticleCategory');
		
		//第二步:得到分类本身的信息
		$articleCategory = $articleCategoryModel->getRowById($this->categoryId);
		
		if(sizeof($articleCategory)==0){
			return;
		}
		
		
		
		//第三步:得到分类所拥有的文章列表
		$where = new Where();
		$where->equalTo('article_sort_id', $this->categoryId);
		
		$articleList = $articleModel->getRowByCondition($where);
		
		if(sizeof($articleList)==0){
			return;
		}
		
		
		$childrenElementList  = array_slice($articleList,0,$this->childrenElementCount);
		
		$url = $this->serviceManager->get('Controller\Plugin\Manager')->get('url');
		
		foreach($childrenElementList as $key=>$element){
			$childrenElementList[$key]['href'] = $url->fromRoute('contact-content-route',array('id'=>$element['id']));
		}
		
		//第三步:渲染视图模版，添加css和js的路径
		$phpRenderer 		= $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		$cssPath = $basePathViewHelper( sprintf("component/article/sidebar/style%s/images/component.css",$this->styleNumber));
		$phpRenderer->headLink()->appendStylesheet($cssPath);
		
		$this->setVariable('category', $articleCategory);
		$this->setVariable('childrenElementList', $childrenElementList);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



