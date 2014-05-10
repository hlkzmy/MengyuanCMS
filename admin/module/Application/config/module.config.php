<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
		
    'router' => array(
        'routes' => array(
        		
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                    	'controller' => 'Admin\Controller\Index',
                        'action'     => 'console',
                    ),
                ),
            ),
            
        		
            'admin' => array(
						'type'    => 'Segment',
            			'options' => array(
                    			'route'    => '/[:controller[/:action]][/:m]',
                    			'constraints' => array(
                    						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    						'm'          => '[a-zA-Z]*',
                    			),
                    			'defaults' => array(
                    						'__NAMESPACE__' => 'Admin\Controller',
                    						'controller'    => 'Index',
                    						'action'        => 'ShowUserLogin',
                    			),
                    	),
            ),
            
           
            
           
                    		
                    			
                    
        ),
    ),
    'service_manager' => array(
    			
    		'factories' => array(
    
    				'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
    
    				'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
    
    				'Zend\Db\Adapter\Connection'=>function($serviceManager){
    
    					$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
    					//首先得到数据库适配器对象
    
    					$dbConnection = $dbAdapter->getDriver()->getConnection();
    					//通过得到数据库驱动从而得到数据库的连接
    
    					return $dbConnection;
    					//返回数据库的连接
    
    				},

    					
    		),
    ),
    
    /**
     * 以下是为了使用导航栏的admin的方法所进行的配置
     */
    'navigation_helpers'=>array(
    		'invokables'=>array(
    				'Admin'=>'Etah\Mvc\View\Helper\Navigation\Admin'
    		)
    ),
    
    /**
     * 以下是为了使用dwz自定义的表单组件所进行的配置
     */
    'form_elements'=>array(
    	'invokables'=>array(
    		'formdwzlookup'	 => 'Etah\Mvc\View\Helper\Form\Dwz\FormDwzLookup',
    	)
    ),
    
    'view_helpers'=>array(
    	'invokables'=>array(
    		'formdwzlookup'	 => 'Etah\Mvc\View\Helper\Form\Dwz\FormDwzLookup',
         )
    ),
    				
    'translator' => array(
        'locale' => 'zh_CN',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
         ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
        	'error/403'               => __DIR__ . '/../view/error/403.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
        	'error/405'               => __DIR__ . '/../view/error/405.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
        	'Application' =>dirname(__DIR__) . '/view',
        ),
    ),	
    
    'controller_plugins' => array(
    		'invokables' => array(
    				'Permission' => 'Etah\Mvc\Plugin\Permission\Permission',
    		),
    ),
    
    
    
);
