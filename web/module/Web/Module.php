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
use Cms\Component\Social\Weixin\Content as WeixinViewModel;

class Module
{
	
	
	public function onBootStrap(MvcEvent $mvcEvent){
		
		$serviceManager = $mvcEvent->getApplication()->getServiceManager();
		
		$phpRenderer = $serviceManager->get('Zend\View\Renderer\PhpRenderer');
		
		$friendLinkViewModel = new friendLinkViewModel($serviceManager);
		$friendLinkViewModel->setChildrenElementType('title');
		$friendLinkViewModel->addTitleChildrenElement(1,'北大法意','http://www.lawyee.net/index.asp');
		$friendLinkViewModel->addTitleChildrenElement(2,'九江新闻网','http://www.jjxw.cn/');
		$friendLinkViewModel->addTitleChildrenElement(3,'江西省律师协会','http://www.jxlawyer.com/');
		$friendLinkViewModel->addTitleChildrenElement(4,'中国律师网','http://www.acla.org.cn/');
		$friendLinkViewModel->addTitleChildrenElement(5,'中国法院网','http://www.chinacourt.org/index.shtml');
		$friendLinkViewModel->componentRender();
		
		//微信分享插件
		$weixinViewModel = new WeixinViewModel($serviceManager);
		$weixinViewModel->componentRender();
		
		
		$phpRenderer->layout()->addChild($friendLinkViewModel,'friendLinkViewModel');
		$phpRenderer->layout()->addChild($weixinViewModel,'weixinViewModel');
		
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
