<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array (
		
		'router' => array(
				
			'routes' => array(
						/*----------------------------静态路由开始----------------------------*/
						'zhaomengyuan' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/about',
										'defaults' => array (
												'controller' => 'Web\Controller\About',
												'action' => 'index'
										)
								)
						)
						
				)//routes end
		),
		
		
		
);//array end

