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
use Cms\Component\Banner\Picture\Content as BannerPicture;
use Cms\Component\Article\Details\Content as ArticleDetails;
use Cms\Component\Article\Sidebar\Title\Content as ArticleCategorySidebar;
use Cms\Component\Article\BreadCrumb\Title\Content as ArticleBreadCrumb;//加载文章列表的组件


class ContactController extends WebBaseController
{
	
	/**
	 * 因为联系我们下面的每个栏目点进去的时候，实际上栏目点进去的时候不是文章列表，而是文章具体的内容
	 *
	 * 所以导航栏的 联系我们  点击进去的时候  contact.html 
	 * 首先去读 contact.html 所配置指向的文章的id,然后映射到这里来
	 * 然后查询文章id所属的文章的分类，然后查询该文章分类下文章分类的列表，作为侧边栏的内容，
	 * 形成的侧边栏中的链接也是重新链接到这个方法上
	 * 然后根据文章id查询文章的内容，作为右侧的内容
	 * @return \Zend\View\Model\ViewModel
	 */
    
	public function contentAction()
    {
    	
    	$id = $this->params('id');//从url中拿到文章的id
    	 
    	$serviceLocator = $this->getServiceLocator();//
    	
    	//第一步:通过文章id拿到文章所属的分类id
    	$articleModel = $serviceLocator->get('Web\Model\ArticleModel');
    	$articleCategory   = $articleModel->getRowById($id,array('article_sort_id'));
    	if(sizeof($articleCategory)==0){
    		die('文章id非法，请不要尝试非法输入');
    	}
    	
    	$articleCategoryId = $articleCategory['article_sort_id'];
    	
    	//第一步：栏目页的bannner
    	$topBannerViewModel = new BannerPicture($serviceLocator);
    	$topBannerViewModel->setBannerPictureName('contact_banner.jpg');
    	$topBannerViewModel->componentRender();
    	 
    	//第二步：加载文章侧边栏视图
    	$articleSidebarCategory = new ArticleCategorySidebar($serviceLocator);
    	$articleSidebarCategory->setCategoryId($articleCategoryId);
    	$articleSidebarCategory->setTemplateStyle(2);
    	$articleSidebarCategory->componentRender();
    	 
    	//第四步：加载当前文章的面包屑路径ArticleBreadCrumb
    	$articleBreadCrumb = new ArticleBreadCrumb($serviceLocator);
    	$articleBreadCrumb->setArticleId($id);
    	$articleBreadCrumb->componentRender();
    	
    	//第五步:对于文章内容页的视图
    	$articleDetailsViewModel  = new ArticleDetails($serviceLocator);
    	$articleDetailsViewModel->setArticleId($id);
    	$articleDetailsViewModel->setShowArticleTitle(false);
    	$articleDetailsViewModel->setShowArticleInfo(false);
    	$articleDetailsViewModel->setShowArticleSubTitle(false);
    	$articleDetailsViewModel->componentRender();
    	 
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $topBannerViewModel,'topBannerViewModel');
    	$viewModel->addChild( $articleBreadCrumb,'articleBreadCrumbViewModel');
    	$viewModel->addChild($articleSidebarCategory,'articleSidebarCategoryViewModel');
    	$viewModel->addChild($articleDetailsViewModel,'articleDetailsViewModel');
    	return $viewModel;
    }
    
    
}
