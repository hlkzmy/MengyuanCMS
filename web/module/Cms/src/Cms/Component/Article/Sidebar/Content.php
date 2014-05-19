<?php

namespace Cms\Component\Article\Sidebar;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;
use Zend\Db\Sql\Where;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $categoryId   = null;//文章分类的id
	
	protected $categoryName = null;//文章分类的名称
	
	protected $childrenCategoryCount = 5;//侧边栏文章分类的个数
	
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	
	/**
	 * 设置栏目的标题
	 */
	public function setCategoryName($name){
		$this->categoryName = $name;
		$this->setVariable('categoryName', $name);
		return $this;
		
	}//function setColumnTitle() end
	
	
	/**
	 * 设置栏目要读取哪个分类之下的文章
	 * @param $id 
	 */
	public function setCategoryId($id){
		$this->categoryId = $id;
		$this->setVariable('categoryId', $id);
		return $this;
	}//function setCategoryId() end
	
	/**
	 * 设置侧边栏的文章分类的个数
	 * $param $count
	 */
	public function setChildrenCategoryCount($count){
		$this->childrenCategoryCount = $count;
		return $this;
	}
	
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//第一步:查询文章分类相关信息
		if(is_null($this->categoryId)){
			return;//如果分类ID为空的前提下，直接return
		}
		
		$articleCategoryModel = $this->serviceManager->get('Cms\Component\Article\Sidebar\Model\ArticleCategory');
		
		//第二步:得到分类本身的信息
		$articleCateogry = $articleCategoryModel->getRowById($this->categoryId);
		
		if(sizeof($articleCateogry)==0||sizeof($articleCateogry)==0){
			return;
		}
		
		
		//如果有子分类的话，导航栏就是该分类和该分类的子分类的列表
		if($articleCateogry['right_number']-$articleCateogry['left_number']>1){
			 $where = new Where();
			 $where->equalTo('parent_id', $this->categoryId);
			 $childrenArticleCategoryList = $articleCategoryModel->getRowByCondition($where);//得到当前分类的子节点
			 $parentArticleCategory = $articleCateogry;//把当前分类当作导航栏的父节点
		}
		else{//如果有子分类的话，导航栏就是该分类的父分类 和 该分类的兄弟分类的列表
			
			//得到当前分类的父分类
			$parentArticleCategory = $articleCategoryModel->getRowById($articleCateogry['parent_id']);
			
			//再通过父分类查询子分类
			$where = new Where();
			$where->equalTo('parent_id', $parentArticleCategory['id']);
			$childrenArticleCategoryList = $articleCategoryModel->getRowByCondition($where);//得到当前分类的子节点
			
		}
		$childrenArticleCategoryList  = array_slice($childrenArticleCategoryList,0,$this->childrenCategoryCount);
		
		$url = $this->serviceManager->get('Controller\Plugin\Manager')->get('url');
		
		foreach($childrenArticleCategoryList as $key=>$element){
			$childrenArticleCategoryList[$key]['href'] = $url->fromRoute('article-category-route',array('id'=>$element['id']));
		}
		
		//第三步:渲染视图模版，添加css和js的路径
		$phpRenderer 		= $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		$cssPath = $basePathViewHelper( sprintf("component/article/sidebar/style%s/images/component.css",$this->styleNumber));
		$phpRenderer->headLink()->appendStylesheet($cssPath);
		
		$this->setVariable('parentArticleCategory', $parentArticleCategory);
		$this->setVariable('childrenArticleCategoryList', $childrenArticleCategoryList);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



