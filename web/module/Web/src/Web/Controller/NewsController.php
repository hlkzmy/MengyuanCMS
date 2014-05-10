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

class NewsController extends WebBaseController
{
    public function indexAction()
    {
    	
    	$serviceLocator = $this->getServiceLocator();
    	 
    	$honorViewModel  = new ArticleColumn($serviceLocator);
    	$honorViewModel->setCategoryId(20);
    	$honorViewModel->setArticleCount(10);
    	$honorViewModel->componentRender();
    	 
    	 
    	$dutyViewModel = new ArticleColumn($serviceLocator);
    	$dutyViewModel->setCategoryId(42);
    	$dutyViewModel->setArticleCount(10);
    	$dutyViewModel->componentRender();
    	 
    	 
    	$advantageViewModel = new ArticleColumn($serviceLocator);
    	$advantageViewModel->setCategoryId(43);
    	$advantageViewModel->setArticleCount(10);
    	$advantageViewModel->componentRender();
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $honorViewModel,'sideArticleColumnViewModel');
    	$viewModel->addChild( $dutyViewModel,'leftArticleColumnViewModel');
    	$viewModel->addChild( $advantageViewModel,'rightArticleColumnViewModel');
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
    
    
    /**
     *  显示文章内容的页面
     */
    public function contentAction(){
    	
    	$id = $this->params('id');
    	
    	$serviceLocator = $this->getServiceLocator();
    	
		//对于文章内容页的视图
    	$articleDetailsViewModel  = new ArticleDetails($serviceLocator);
    	$articleDetailsViewModel->setArticleId($id);
    	$articleDetailsViewModel->componentRender();
    	
    	
    	$viewModel = new ViewModel();
    	$viewModel->addChild($articleDetailsViewModel,'articleDetailsViewModel');
    	return $viewModel;
    }//function contentAction() end
    
    
}
