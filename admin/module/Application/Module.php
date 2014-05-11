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
use Zend\View\HelperPluginManager;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Navigation\Navigation;

use Zend\Log\Writer;

use Etah\Mvc\Factory\ServiceLocator\ServiceLocatorFactory;



class Module {
	
	protected $role;
	protected $menu;
	
	public function onBootstrap(MvcEvent $e) {
		
		$eventManager = $e->getApplication ()->getEventManager();
		
		//$e->getResponse()
		
		$moduleRouteListener = new ModuleRouteListener ();
		$moduleRouteListener->attach ( $eventManager );
		
		$serviceManager = $e->getApplication ()->getServiceManager ();
		// 得到serviceManager服务管理者
		
		// 以下是为了在任意地方使用serviceLocator，注册的ServiceLocatorFactory
		ServiceLocatorFactory::setInstance ( $serviceManager );
		
		// 以下是为了在使用Ajax的请求的方法的时候禁用布局模板，比如checkUserAdd方法
		$sharedEvents = $e->getApplication ()->getEventManager ()->getSharedManager ();
		
		$sharedEvents->attach ( 'Zend\Mvc\Controller\AbstractActionController', 'dispatch', function ($e) {
			
			$e->getResult ()->setTerminal ( true );
			
		} ); // attach end
		    
		//在路由的时候进行权限检查
		$eventManager->attach ('route', array ($this,'checkAcl'),-100); 
		//$eventManager->attach ('route', array ($this,'writeLog'),-100);
		
		
				
		// 以下是为了在全局中使用一些公用的文档信息，如headTitle等内容
		$renderer = $serviceManager->get ( 'Zend\View\Renderer\PhpRenderer' );
		
		$renderer->layout()->setVariable('copyright','康润内容管理系统'); 
		
		$renderer->headTitle ( '康润内容管理系统' );
	}
	
	
	public function checkAcl($e) {
		
		$routeMatch = $e->getRouteMatch();
		
		if ($routeMatch===null) {
			die('服务器没有取到路由信息，禁止访问！');
		}
		
		//进行权限认证
		$serviceManager = $e->getApplication ()->getServiceManager ();
		$permission = $serviceManager->get ('ControllerPluginManager')->get ('Permission');
		$permission->auth($e);

		$permission->menu($e);
		
	}//function checkAcl() end
	
	
	
	public function writeLog($e){
		
		$serviceManager = $e->getApplication ()->getServiceManager ();
		$logManager = $serviceManager->get ('ControllerPluginManager')->get ('LogManager');
		$logManager->writeLogs($e);
		
	}
	
	public function getConfig() {
		
		return  include __DIR__ . '/config/module.config.php';
		
	}
	public function getServiceConfig() {
		
		return  include __DIR__ . '/config/server.config.php';
		
	}

	public function getAutoloaderConfig() {
		return array (
				'Zend\Loader\StandardAutoloader' => array (
						'namespaces' => array (
								__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
								'Base'  => __DIR__ . '/src/' . 'Base',
								'Admin' => __DIR__ . '/src/' . 'Admin'
						) 
				) 
		);
	}
	
	
}
