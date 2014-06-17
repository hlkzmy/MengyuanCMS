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
use Cms\Component\Slide\Javascript\Content as JavascriptSlideControl;//幻灯片的组件

class IndexController extends WebBaseController
{
	
    public function indexAction()
    {
    	
    	$serviceLocator = $this->getServiceLocator();
    	
    	//第一步:得到首页幻灯片的内容
    	$javascriptSlideViewModel = new JavascriptSlideControl($serviceLocator);
    	$javascriptSlideViewModel	->setImageBasePath('theme/default/common/slide');
    	$javascriptSlideViewModel	->addSlideElement(1,'康润业务',null,'1.jpg','/category-13.html')
    								->addSlideElement(2,'关于康润',null,'2.jpg','/category-14.html')
    								->addSlideElement(3,'康润团队',null,'3.jpg','/category-23.html');
    								
    	$javascriptSlideViewModel->componentRender();
    	
    	 
    	$leftArticleColumnViewModel  = new ArticleColumn($serviceLocator);
    	$leftArticleColumnViewModel	->setCategoryId(20)
    								->setArticleTitleLength(20)
    								->setArticleCount(6)
    								->setTemplateStyle(2)
    								->componentRender();
    	
    	
    	$middleArticleColumnViewModel = new ArticleColumn($serviceLocator);
    	$middleArticleColumnViewModel	->setCategoryId(42)
    									->setArticleTitleLength(20)
								    	->setArticleCount(6)
								    	->setArticleTitleWithDate(true)
								    	->setTemplateStyle(2)
								    	->componentRender();
    	 
    	 
    	 
    	$rightArticleColumnViewModel = new ArticleColumn($serviceLocator);
		$rightArticleColumnViewModel->setCategoryId(43)
									->setArticleTitleLength(20)
							    	->setArticleCount(6)
							    	->setArticleTitleWithDate(true)
							    	->setTemplateStyle(2)
							    	->componentRender();
    	 
    	$viewModel = new ViewModel();
    	$viewModel->addChild( $javascriptSlideViewModel    ,'javascriptSlideViewModel');
    	$viewModel->addChild( $leftArticleColumnViewModel  ,'leftArticleColumnViewModel');
    	$viewModel->addChild( $middleArticleColumnViewModel,'middleArticleColumnViewModel');
    	$viewModel->addChild( $rightArticleColumnViewModel ,'rightArticleColumnViewModel');
    	
    	
    	return $viewModel;
    }
}
