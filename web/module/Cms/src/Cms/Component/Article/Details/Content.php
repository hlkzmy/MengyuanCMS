<?php

namespace Cms\Component\Article\Details;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $articleId   = null;//文章的id
	
	protected $articleTitle = null;//文章的标题
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplate('Cms/Component/Article/Details/Template/Content');
	}//function __construct() end
	
	
	/**
	 * 设置栏目的标题
	 */
	public function setArticleTitle($title){
		$this->articleTitle = $title;
		$this->setVariable('articleTitle', $title);
		return $this;
	}//function setColumnTitle() end
	
	/**
	 * 设置栏目要读取哪个分类之下的文章
	 * @param $categoryId 
	 */
	public function setArticleId($id){
		$this->articleId = $id;
		$this->setVariable('articleId', $id);
		return $this;
	}//function setCategoryId() end
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//第一步:查询文章分类相关信息
		if(is_null($this->articleId)){
			return;//如果分类ID为空的前提下，直接return
		}
		
		$articleModel = $this->serviceManager->get('Cms\Component\Article\Details\Model\Article');
		$articleContentModel = $this->serviceManager->get('Cms\Component\Article\Details\Model\ArticleContent');
		
		$article 		= $articleModel->getRowById($this->articleId);
		$articleContent = $articleContentModel->getRowById($this->articleId);
		if(sizeof($article)==0||sizeof($articleContent)==0){
			return;
		}
		
		$article['content'] = $articleContent['content'];
		
		$this->setArticleId($article['id']);
		$this->setArticleTitle($article['title']);
		
		$this->setVariable('article', $article);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



