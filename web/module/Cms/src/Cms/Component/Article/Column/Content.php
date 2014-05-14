<?php

namespace Cms\Component\Article\Column;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $categoryId   = null;//栏目的ID
	
	protected $categoryName = null;//栏目的标题
	
	protected $articleCount = 5; //设置文章的总数
	
	protected $articleTitleLength = 10;//设置文章标题的长度
	
	protected $articleTitleWithDate = false;//文章标题
	
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	
	/**
	 * 页面中每个地方的所使用的模板可能并不一样，但是里面的内容是一样的
	 * 这个时候在一个模板中写很多的判断语句就有一点不合算，
	 * 让用户直接设置完整的模板路径难度又太大，所以设置一个组件模板的编号是最简单的
	 */
	public function setTemplateStyle($styleNumber){
		$this->setTemplate(sprintf('Cms/Component/Article/Column/Template/Style%s',$styleNumber));
		return $this;
	}
	
	
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
	 * @param $categoryId 
	 */
	public function setCategoryId($id){
		$this->categoryId = $id;
		$this->setVariable('categoryId', $id);
		return $this;
	}//function setCategoryId() end
	
	
	/**
	 * 设置一个栏目之下显示文章的总数
	 */
	public function setArticleCount($count){
		$this->articleCount = $count;
		return $this;
	}
	
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
		
		$articleSortModel = $this->serviceManager->get('Cms\Component\Article\Column\Model\ArticleSort');
		
		$articleCategoryInfo = $articleSortModel->getRowById($this->categoryId);
		if(sizeof($articleCategoryInfo)==0){
			return;//如果分类ID为空的前提下，直接return
		}
		
		$this->setCategoryId($articleCategoryInfo['id']);
		$this->setCategoryName($articleCategoryInfo['name']);
		
		//第二步：查询该文章分类之下所有文章列表的信息
		$articleModel = $this->serviceManager->get('Cms\Component\Article\Column\Model\Article');
		
		$column = array('id','title');
		if($this->articleTitleWithDate){
			$column['date'] = 'add_time';
		}
		
		$articleList = $articleModel->getArticleList($this->categoryId,$column);
		
		$articleList = array_slice($articleList, 0 ,$this->articleCount);
		
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
		
		//2.对文章栏目的标题，包括More、加号等按钮
		$articleCategoryHref = $url->fromRoute('article-category-route',array('id'=>$this->categoryId));
		$this->setVariable('articleCategoryHref', $articleCategoryHref);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



