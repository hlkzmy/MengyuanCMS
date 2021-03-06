<?php

namespace Cms\Component\Article\Details;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $articleId   = null;//文章的id
	
	protected $articleTitle = null;//文章的标题
	
	
	
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		$this->setTemplateStyle(1);
		$this->setShowArticleTitle(true);
		$this->setShowArticleSubTitle(true);
		$this->setShowArticleInfo(true);
	}//function __construct() end
	
	
	public function setShowArticleTitle($status){
		$this->setVariable('showArticleTitle', $status);
	}
	
	public function setShowArticleSubTitle($status){
		$this->setVariable('showArticleSubTitle', $status);
	}
	
	public function setShowArticleInfo($status){
		$this->setVariable('showArticleDetailsInfo', $status);
	}
	
	
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
		
		//第二步:渲染视图模版，添加css和js的路径
		$phpRenderer 		= $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		$cssPath = $basePathViewHelper( sprintf("component/article/details/style%s/images/component.css",$this->styleNumber));
		$phpRenderer->headLink()->appendStylesheet($cssPath);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



