<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Web;

use Zend\Mvc\MvcEvent;

//加载友情链接的视图组件，避免在每个视图中都要写一次视图加载的问题
use Cms\Component\FriendLink\Content as friendLinkViewModel;

class Module
{
	
	
	public function onBootStrap(MvcEvent $mvcEvent){
		
		$serviceManager = $mvcEvent->getApplication()->getServiceManager();
		
		$phpRenderer = $serviceManager->get('Zend\View\Renderer\PhpRenderer');
		
		
		$layout = $serviceManager->get('Controller\Plugin\Manager')->get('layout');
		
		$friendLinkViewModel = new friendLinkViewModel($serviceManager);
		$friendLinkViewModel->setChildrenElementType('title');
		$friendLinkViewModel->addTitleChildrenElement(1,'友情链接1','http://www.baidu.com');
		$friendLinkViewModel->addTitleChildrenElement(2,'友情链接2','http://www.baidu.com');
		$friendLinkViewModel->addTitleChildrenElement(3,'友情链接3','http://www.baidu.com');
		$friendLinkViewModel->addTitleChildrenElement(4,'友情链接4','http://www.baidu.com');
		$friendLinkViewModel->addTitleChildrenElement(5,'友情链接5','http://www.baidu.com');
		
		$friendLinkViewModelRenderResult = $friendLinkViewModel->componentRender('html');
		
		$phpRenderer->layout()->setVariable('friendLinkViewModel',$friendLinkViewModelRenderResult);
		
		
	}//function onBootStrap();
	
	
	
	public function getConfig()
    {
    	return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return include __DIR__ . '/config/service.config.php';
    
    }
    
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
