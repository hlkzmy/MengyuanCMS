<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Application\Factory\ServiceLocatorFactory;

use Application\Model\UserModel;

use Zend\Navigation\Navigation;
use Zend\Navigation\Page;
use Zend\Navigation\Page\Mvc as MvcPage; 


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $serviceManager = $e->getApplication()->getServiceManager();
        //得到serviceManager服务管理者
         
        //以下是为了在任意地方使用serviceLocator，注册的ServiceLocatorFactory
        ServiceLocatorFactory::setInstance($serviceManager);
         
        $renderer = $serviceManager->get('Zend\View\Renderer\PhpRenderer');
        
        $renderer->doctype('XHTML1_TRANSITIONAL');
        
        $renderer->headTitle('康润律师事务所');
        
   	}//function onBootstrap end
    
    
    public function getServiceConfig()
    {
    	return include __DIR__ . '/config/service.config.php';
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
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
