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
use Cms\Component\Article\Column\Content as ArticleColumn;//内容组件的文章栏目

class IndexController extends WebBaseController
{
	
    public function indexAction()
    {
    	
    	$serviceLocator = $this->getServiceLocator();
    	 
    	$leftArticleColumnViewModel  = new ArticleColumn($serviceLocator);
    	$leftArticleColumnViewModel	->setCategoryId(13)
    								->setArticleTitleLength(21)
    								->setArticleCount(8)
    								->setTemplateStyle(2)
    								->componentRender();
    	
    	
    	$middleArticleColumnViewModel = new ArticleColumn($serviceLocator);
    	$middleArticleColumnViewModel	->setCategoryId(14)
    									->setArticleTitleLength(21)
								    	->setArticleCount(8)
								    	->setArticleTitleWithDate(true)
								    	->setTemplateStyle(2)
								    	->componentRender();
    	 
    	 
    	 
    	$rightArticleColumnViewModel = new ArticleColumn($serviceLocator);
		$rightArticleColumnViewModel->setCategoryId(23)
									->setArticleTitleLength(21)
							    	->setArticleCount(8)
							    	->setArticleTitleWithDate(true)
							    	->setTemplateStyle(2)
							    	->componentRender();
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $leftArticleColumnViewModel   ,'leftArticleColumnViewModel');
    	$viewModel->addChild( $middleArticleColumnViewModel ,'middleArticleColumnViewModel');
    	$viewModel->addChild( $rightArticleColumnViewModel  ,'rightArticleColumnViewModel');
    	
    	
    	return $viewModel;
    }
}
