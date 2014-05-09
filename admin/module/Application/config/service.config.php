<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use System\Model\UserModel;
use Application\Plugin\Permission\Model\AccessModel;
use Application\Plugin\Permission\Model\UserRoleModel;
use Application\Plugin\Permission\Model\NodeModel;
use Application\Plugin\Permission\Model\MenuModel;

return array (
		
				'factories' => array (
						'Application\Model\MenuModel' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							return new MenuModel ( $dbAdapter );
						},
						'Application\Plugin\Permission\Model\AccessModel' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							return new AccessModel ( $dbAdapter );
						},
						'Application\Plugin\Permission\Model\NodeModel' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							return new NodeModel ( $dbAdapter );
						},
						'Application\Plugin\Permission\Model\UserRoleModel' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							return new UserRoleModel ( $dbAdapter );
						},
						'Application\Plugin\Permission\Model\MenuModel' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							return new MenuModel ( $dbAdapter );
						},
						'System\Model\UserModel' => function ($sm) {
							$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
							return new UserModel ( $dbAdapter );
						} ,
		
				)//factories end
					
);//array end
    
    
