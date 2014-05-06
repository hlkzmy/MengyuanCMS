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
use Web\Plugin\Article\Column as ArticleColumn;


class AboutController extends WebBaseController
{
    public function indexAction()
    {
    	
    	$honorViewModel     = new ArticleColumn();
    	$honorViewModel->setColumnTitle('康润荣誉');
    	
    	
    	$dutyViewModel      = new ArticleColumn();
    	$dutyViewModel->setColumnTitle('康润社会责任');
    	
    	$advantageViewModel = new ArticleColumn();
    	$advantageViewModel->setColumnTitle('康润优势');
    	
    	

    	$viewModel = new ViewModel();
    	$viewModel->addChild( $honorViewModel,'sideArticleColumnViewModel');
    	$viewModel->addChild( $dutyViewModel,'leftArticleColumnViewModel');
    	$viewModel->addChild( $advantageViewModel,'rightArticleColumnViewModel');
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
}
