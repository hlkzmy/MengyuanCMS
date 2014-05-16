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
use Cms\Component\Slide\Javascript\Content as JavascriptSlideControl;

class IndexController extends WebBaseController
{
	
    public function indexAction()
    {
    	
    	$serviceLocator = $this->getServiceLocator();
    	
    	//第一步:得到首页幻灯片的内容
    	$javascriptSlideViewModel = new JavascriptSlideControl($serviceLocator);
    	$javascriptSlideViewModel	->setImageBasePath('theme/default/common/slide');
    	$javascriptSlideViewModel	->addSlideElement(1,'测试标题1','测试标题1的相关描述','1.jpg')
    								->addSlideElement(2,'测试标题2','测试标题2的相关描述','2.jpg')
    								->addSlideElement(2,'测试标题2','测试标题3的相关描述','3.jpg');
    	
    								
    	$javascriptSlideViewModel->componentRender();
    	
    	
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
    	$viewModel->addChild( $javascriptSlideViewModel    ,'javascriptSlideViewModel');
    	$viewModel->addChild( $leftArticleColumnViewModel  ,'leftArticleColumnViewModel');
    	$viewModel->addChild( $middleArticleColumnViewModel,'middleArticleColumnViewModel');
    	$viewModel->addChild( $rightArticleColumnViewModel ,'rightArticleColumnViewModel');
    	
    	
    	return $viewModel;
    }
}
