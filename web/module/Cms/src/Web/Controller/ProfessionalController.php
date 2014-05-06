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

class ProfessionalController extends WebBaseController
{
    public function indexAction()
    {
    	

    	
        $viewModel = new ViewModel();
    	$viewModel->setTemplate("web/common/layout");
    	return $viewModel;
    }
}