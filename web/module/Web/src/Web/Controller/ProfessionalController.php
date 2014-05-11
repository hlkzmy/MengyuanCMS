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

class ProfessionalController extends WebBaseController
{
    public function indexAction()
    {
    	
    	$serviceLocator = $this->getServiceLocator();
    	 
    	$honorViewModel  = new ArticleColumn($serviceLocator);
    	$honorViewModel->setCategoryId(15);
    	$honorViewModel->setArticleCount(9);
    	$honorViewModel->setArticleTitleLength(16);
    	$honorViewModel->componentRender();
    	 
    	 
    	$dutyViewModel = new ArticleColumn($serviceLocator);
    	$dutyViewModel->setCategoryId(16);
    	$dutyViewModel->setArticleCount(9);
    	$dutyViewModel->setArticleTitleLength(20);
    	$dutyViewModel->setArticleTitleWithDate(true);
    	$dutyViewModel->componentRender();
    	 
    	 
    	$advantageViewModel = new ArticleColumn($serviceLocator);
    	$advantageViewModel->setCategoryId(38);
    	$advantageViewModel->setArticleCount(9);
    	$advantageViewModel->setArticleTitleLength(20);
    	$advantageViewModel->setArticleTitleWithDate(true);
    	$advantageViewModel->componentRender();
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $honorViewModel,'sideArticleColumnViewModel');
    	$viewModel->addChild( $dutyViewModel,'leftArticleColumnViewModel');
    	$viewModel->addChild( $advantageViewModel,'rightArticleColumnViewModel');
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
}
