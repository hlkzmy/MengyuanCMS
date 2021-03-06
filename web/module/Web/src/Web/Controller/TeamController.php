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
use Cms\Component\Article\Column\Content as ArticleColumn;
use Cms\Component\Banner\Picture\Content as BannerPicture;
use Cms\Component\Article\Sidebar\Category\Content as ArticleCategorySidebar;

class TeamController extends WebBaseController
{
    public function indexAction()
    {
    	$categoryId = $this->params('id');
    	 
    	$serviceLocator = $this->getServiceLocator();
    	 
    	//第一步：栏目页的bannner
    	$topBannerViewModel = new BannerPicture($serviceLocator);
    	$topBannerViewModel->setBannerPictureName('team_banner.jpg');
    	$topBannerViewModel->componentRender();
    	 
    	//第二步：三个文章栏目页
    	$honorViewModel  = new ArticleColumn($serviceLocator);
    	$honorViewModel->setCategoryId(18);
    	$honorViewModel->setArticleTitleLength(16);
    	$honorViewModel->setArticleCount(9);
    	$honorViewModel->componentRender();
    	 
    	 
    	$dutyViewModel = new ArticleColumn($serviceLocator);
    	$dutyViewModel->setCategoryId(19);
    	$dutyViewModel->setArticleCount(9);
    	$dutyViewModel->setArticleTitleWithDate(true);
    	$dutyViewModel->setArticleTitleLength(19);
    	$dutyViewModel->componentRender();
    	 
    	 
    	$advantageViewModel = new ArticleColumn($serviceLocator);
    	$advantageViewModel->setCategoryId(41);
    	$advantageViewModel->setArticleCount(9);
    	$advantageViewModel->setArticleTitleWithDate(true);
    	$advantageViewModel->setArticleTitleLength(19);
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
}
