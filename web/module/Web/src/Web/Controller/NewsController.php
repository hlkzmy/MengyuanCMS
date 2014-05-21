<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Web\Controller;

use Web\Controller\WebBaseController;
use Zend\View\Model\ViewModel;
use Cms\Component\Article\Column\Content  as ArticleColumn;
use Cms\Component\Article\Details\Content as ArticleDetails;
use Cms\Component\Banner\Picture\Content as BannerPicture;
use Cms\Component\Article\Sidebar\Category\Content as ArticleCategorySidebar;
use Cms\Component\Article\ListControl\Content as ArticleListControl;//加载文章列表的组件
use Cms\Component\Article\BreadCrumb\Content as ArticleBreadCrumb;//加载文章列表的组件

class NewsController extends WebBaseController
{
	
	/**
	 * 文章页的首页
	 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
	 */
    public function indexAction()
    {
    	
    	$categoryId = $this->params('id');
    	 
    	$serviceLocator = $this->getServiceLocator();
    	 
    	//第一步：栏目页的bannner
    	$topBannerViewModel = new BannerPicture($serviceLocator);
    	$topBannerViewModel->setBannerPictureName('news_banner.jpg');
    	$topBannerViewModel->componentRender();
    	
    	//第二步：三个文章栏目页 
    	$honorViewModel  = new ArticleColumn($serviceLocator);
    	$honorViewModel->setArticleTitleLength(16);
    	$honorViewModel->setCategoryId(20);
    	$honorViewModel->setArticleCount(9);
    	$honorViewModel->componentRender();
    	 
    	 
    	$dutyViewModel = new ArticleColumn($serviceLocator);
    	$dutyViewModel->setCategoryId(42);
    	$dutyViewModel->setArticleCount(9);
    	$dutyViewModel->setArticleTitleWithDate(true);
    	$dutyViewModel->setArticleTitleLength(20);
    	$dutyViewModel->componentRender();
    	 
    	 
    	$advantageViewModel = new ArticleColumn($serviceLocator);
    	$advantageViewModel->setCategoryId(43);
    	$advantageViewModel->setArticleCount(9);
    	$advantageViewModel->setArticleTitleWithDate(true);
    	$advantageViewModel->setArticleTitleLength(20);
    	$advantageViewModel->componentRender();
    	 
    	//第三步：栏目页的文章分类页的导航栏
    	$articleCategorySidebarViewModel = new ArticleCategorySidebar($serviceLocator);
    	$articleCategorySidebarViewModel->setCategoryId($categoryId);
    	$articleCategorySidebarViewModel->componentRender();
    	
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $honorViewModel,'sideArticleColumnViewModel');
    	$viewModel->addChild( $topBannerViewModel,'topBannerViewModel');
    	$viewModel->addChild( $dutyViewModel,'leftArticleColumnViewModel');
    	$viewModel->addChild( $advantageViewModel,'rightArticleColumnViewModel');
    	$viewModel->addChild( $articleCategorySidebarViewModel,'articleCategorySidebarViewModel');
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
    
    
    /**
     * 往文章的每个分类之下填充数据
     */
    private function init(){
    	
    	$serviceLocator = $this->getServiceLocator();
    	$articleModel 			= $serviceLocator->get('Web\Model\ArticleModel');
    	$articleSortModel 		= $serviceLocator->get('Web\Model\ArticleSortModel');
    	$articleContentModel 	= $serviceLocator->get('Web\Model\ArticleContentModel');
    	
    	$articleSortList = $articleSortModel->getArticleSortList();
    	
    	$articleSortIdList = array();
    	foreach($articleSortList as $key=>$element){
    		if($element['right_number']-$element['left_number']==1){
    			array_push($articleSortIdList,$element['id']);
    		}
    	}
    	
  		foreach($articleSortIdList as $articleSortId){
    		for($i=0;$i<100;$i++){
    			$data = array();
    			$data['user_id'] = 1;
    			$data['article_sort_id'] = $articleSortId;
    			$data['title'] = sprintf('测试文章分类%s下测试文章标题%s测试文章标题测试文章标题',$articleSortId,$i);
    			$data['sub_title'] = sprintf('测试文章分类%s下测试文章标题%s',$articleSortId,$i);
    			$data['keyword'] = '关键字1,关键字2';
    			$data['content'] = str_repeat('测试文章内容'.$articleSortId.'-'.$i, 100);
    			$data['hits'] = rand(0,100);
    			$data['add_time'] = date("Y-m-d H:i:s");
    			$data['update_time'] = date("Y-m-d H:i:s");
    			$data['status'] = 'Y';
    			
    			$articleModel->insertRow($data);
    			$id = $articleModel->getLastInsertValue();
    			$content = array();
    			$content['id'] = $id;
    			$content['content'] = $data['content'];
    			$articleContentModel->insertRow($content);
    		}
    	}
    	
    }//function init() end
    
    
    
    
    /**
     * 显示文章分类的列表的页面
     */
    
    public function categoryAction(){
    	
    	$id = $this->params('id');//从url参数中得到文章分类的id
    	
    	$serviceLocator = $this->getServiceLocator();
    	
    	//第一步：栏目页的bannner
    	$topBannerViewModel = new BannerPicture($serviceLocator);
    	$topBannerViewModel->setBannerPictureName('news_banner.jpg');
    	$topBannerViewModel->componentRender();
    	
    	
    	//第二步：加载文章侧边栏视图
    	$articleSidebarCategory = new ArticleCategorySidebar($serviceLocator);
    	$articleSidebarCategory->setCategoryId($id);
    	$articleSidebarCategory->setTemplateStyle(2);
    	$articleSidebarCategory->componentRender();
    	
    	//第三步：加载文章列表的组件
    	$articleListControl = new ArticleListControl($serviceLocator);
    	$articleListControl->setCategoryId($id);
    	$articleListControl->setArticleTitleLength(200);
    	$articleListControl->setArticleTitleWithDate(true);
    	$articleListControl->componentRender();
    	
    	//第四步：加载当前文章的面包屑路径ArticleBreadCrumb
    	$articleBreadCrumb = new ArticleBreadCrumb($serviceLocator);
    	$articleBreadCrumb->setCategoryId($id);
    	$articleBreadCrumb->componentRender();
    	
    	
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $topBannerViewModel,'topBannerViewModel');
    	$viewModel->addChild( $articleBreadCrumb,'articleBreadCrumbViewModel');
    	$viewModel->addChild($articleSidebarCategory,'articleSidebarCategoryViewModel');
    	$viewModel->addChild($articleListControl,'articleListControlViewModel');
    	return $viewModel;
    }//function categoryAction() end
    
    
    
    /**
     *  显示文章内容的页面
     */
    public function contentAction(){
    	
    	$id = $this->params('id');
    	
    	$serviceLocator = $this->getServiceLocator();
    	
    	
    	//第一步：拿到文章的详细内容
    	$articleModel = $serviceLocator->get('Web\Model\ArticleModel');
    	$article = $articleModel->getRowById($id,array('article_sort_id'));
    	
    	if(sizeof($article)==0){
    		die('在系统中没有查询到相关的文章内容,请您返回');
    	}
    	
    	$articleSortId = $article['article_sort_id'];

    	//第二️步：栏目页的bannner
    	$topBannerViewModel = new BannerPicture($serviceLocator);
    	$topBannerViewModel->setBannerPictureName('news_banner.jpg');
    	$topBannerViewModel->componentRender();
    	
    	//第三步：加载文章侧边栏视图
    	$articleSidebarCategory = new ArticleCategorySidebar($serviceLocator);
    	$articleSidebarCategory->setCategoryId($articleSortId);
    	$articleSidebarCategory->setTemplateStyle(2);
    	$articleSidebarCategory->componentRender();
    	
    	//第四步：加载当前文章的面包屑路径ArticleBreadCrumb
    	$articleBreadCrumb = new ArticleBreadCrumb($serviceLocator);
    	$articleBreadCrumb->setCategoryId($articleSortId);
    	$articleBreadCrumb->componentRender();
    	
    	
    	//第五步:对于文章内容页的视图
    	$articleDetailsViewModel  = new ArticleDetails($serviceLocator);
    	$articleDetailsViewModel->setArticleId($id);
    	$articleDetailsViewModel->componentRender();
    	
    	
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $articleBreadCrumb,'articleBreadCrumbViewModel');
    	$viewModel->addChild( $topBannerViewModel,'topBannerViewModel');
    	$viewModel->addChild($articleSidebarCategory,'articleSidebarCategoryViewModel');
    	$viewModel->addChild($articleDetailsViewModel,'articleDetailsViewModel');
    	return $viewModel;
    }//function contentAction() end
    
    
    
    
    
}
