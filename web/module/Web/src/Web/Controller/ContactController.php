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
use Cms\Component\Article\Sidebar\Content as ArticleCategorySidebar;
use Cms\Component\Banner\Picture\Content  as BannerPicture;


class ContactController extends WebBaseController
{
    
 	public function indexAction()
    {
    	
    	
    
    	$viewModel = new ViewModel();
    	return $viewModel;
    }
}
