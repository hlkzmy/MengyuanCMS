<?php

namespace Cms\Component\Article\ListControl;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $categoryId   = null;//栏目的ID
	
	protected $articleTitleLength = 10;//设置文章标题的长度
	
	protected $articleTitleWithDate = false;//文章标题
	
	
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
		
		
		//得到所有子孙分类下的文章列表
		
		
		$articleList = $articleModel->getArticleList($childrenCategoryIdList,$column);
		
		
		//第三步：对于查询的结果做一些处理
		//1.对文章标题的url做操作
		$url = $this->serviceManager->get('Controller\Plugin\Manager')->get('url');
		
		foreach($articleList as $key=>$element){
			$articleList[$key]['href'] = $url->fromRoute('article-content-route',array('id'=>$element['id']));
			
			if($this->articleTitleWithDate){
				$articleList[$key]['date'] = substr($element['date'],0,10);
			}
			
			$articleList[$key]['title'] = mb_substr($element['title'],0,$this->articleTitleLength,'utf-8');
			
		}
		
		$this->setVariable('articleList', $articleList);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



