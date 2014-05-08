<?php

return array(
		
	'router' => array(
		'routes' => array(	
        	/*----------------------------静态路由开始----------------------------*/
        		'about' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/about.html',
        						'defaults' => array (
        								'controller' => 'Web\Controller\About',
        								'action' => 'index'
        						)
        				)
        		),
        		'case' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/case.html',
        						'defaults' => array (
        								'controller' => 'Web\Controller\Case',
        								'action' => 'index'
        						)
        				)
        		),
        		'news' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/news.html',
        						'defaults' => array (
        								'controller' => 'Web\Controller\News',
        								'action' => 'index'
        						)
        				)
        		),
        		'professional' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/professional.html',
        						'defaults' => array (
        								'controller' => 'Web\Controller\Professional',
        								'action' => 'index'
        						)
        				)
        		),
        		'team' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/team.html',
        						'defaults' => array (
        								'controller' => 'Web\Controller\Team',
        								'action' => 'index'
        						)
        				)
        		)
        		
				
		)//routes end
    ),
    
    'controllers' => array (
			'invokables' => array (
				'Web\Controller\Index' => 'Web\Controller\IndexController',
				'Web\Controller\About' => 'Web\Controller\AboutController',
				'Web\Controller\Case' => 'Web\Controller\CaseController',
				'Web\Controller\News' => 'Web\Controller\NewsController',
				'Web\Controller\Professional' => 'Web\Controller\ProfessionalController',
				'Web\Controller\Team' => 'Web\Controller\TeamController',
			) 
	),
	'view_manager' => array(
			'template_path_stack' => array(
					'web'=>__DIR__ . '/../view',
			),
	),
   
);
