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

class TeamController extends WebBaseController
{
    public function indexAction()
    {
    	
    	$serviceLocator = $this->getServiceLocator();
    	 
    	$honorViewModel  = new ArticleColumn($serviceLocator);
    	$honorViewModel->setCategoryId(18);
    	$honorViewModel->setArticleCount(10);
    	$honorViewModel->componentRender();
    	 
    	 
    	$dutyViewModel = new ArticleColumn($serviceLocator);
    	$dutyViewModel->setCategoryId(19);
    	$dutyViewModel->setArticleCount(10);
    	$dutyViewModel->componentRender();
    	 
    	 
    	$advantageViewModel = new ArticleColumn($serviceLocator);
    	$advantageViewModel->setCategoryId(41);
    	$advantageViewModel->setArticleCount(10);
    	$advantageViewModel->componentRender();
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $honorViewModel,'sideArticleColumnViewModel');
    	$viewModel->addChild( $dutyViewModel,'leftArticleColumnViewModel');
    	$viewModel->addChild( $advantageViewModel,'rightArticleColumnViewModel');
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
}
