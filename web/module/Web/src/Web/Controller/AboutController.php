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


class AboutController extends WebBaseController
{
    public function indexAction()
    {
    	$serviceLocator = $this->getServiceLocator();
    	
    	$config = $serviceLocator->get('config');
    	
    	
    	$honorViewModel  = new ArticleColumn($serviceLocator);
    	$honorViewModel->setCategoryId(18);
    	$honorViewModel->setArticleCount(10);
    	$honorViewModel->componentRender();
    	$honorViewModel->setCategoryName('测试栏目标题');
    	
    	
    	$dutyViewModel      = new ArticleColumn($serviceLocator);
    	$dutyViewModel->setCategoryName('康润社会责任');
    	
    	$advantageViewModel = new ArticleColumn($serviceLocator);
    	$advantageViewModel->setCategoryName('康润优势');
    	
    	

    	$viewModel = new ViewModel();
    	$viewModel->addChild( $honorViewModel,'sideArticleColumnViewModel');
    	$viewModel->addChild( $dutyViewModel,'leftArticleColumnViewModel');
    	$viewModel->addChild( $advantageViewModel,'rightArticleColumnViewModel');
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
}
