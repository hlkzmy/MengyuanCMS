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

class NewsController extends WebBaseController
{
    public function indexAction()
    {
    	

    	
        $viewModel = new ViewModel();
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
    
    
    /**
     *  显示文章内容的页面
     */
    public function contentAction(){
    	
    	
    	
    	
    	
    	$viewModel = new ViewModel();
    	return $viewModel;
    }//function contentAction() end
    
    
}
