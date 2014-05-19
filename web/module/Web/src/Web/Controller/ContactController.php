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
use Cms\Component\Article\Sidebar\Content as ArticleCategorySidebar;//加载文章分类侧边栏的组件
use Cms\Component\Article\BreadCrumb\Content as ArticleBreadCrumb;//加载文章列表的组件


class ContactController extends WebBaseController
{
    
 	public function indexAction()
    {
    	
    	$id = $this->params('id');//从url参数中得到文章分类的id
    	 
    	$serviceLocator = $this->getServiceLocator();
    	 
    	//第一步：栏目页的bannner
    	$topBannerViewModel = new BannerPicture($serviceLocator);
    	$topBannerViewModel->setBannerPictureName('default_banner.jpg');
    	$topBannerViewModel->componentRender();
    	 
    	 
    	//第二步：加载文章侧边栏视图
    	$articleSidebarCategory = new ArticleCategorySidebar($serviceLocator);
    	$articleSidebarCategory->setCategoryId($id);
    	$articleSidebarCategory->setTemplateStyle(2);
    	$articleSidebarCategory->componentRender();
    	 
    	
    	 
    	//第四步：加载当前文章的面包屑路径ArticleBreadCrumb
    	$articleBreadCrumb = new ArticleBreadCrumb($serviceLocator);
    	$articleBreadCrumb->setCategoryId($id);
    	$articleBreadCrumb->componentRender();
    	 
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $topBannerViewModel,'topBannerViewModel');
    	$viewModel->addChild( $articleBreadCrumb,'articleBreadCrumbViewModel');
    	$viewModel->addChild($articleSidebarCategory,'articleSidebarCategoryViewModel');
    	return $viewModel;
    }
}
