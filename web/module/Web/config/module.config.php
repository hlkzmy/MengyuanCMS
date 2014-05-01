<?php

return array(
		
	'router' => array(
			
        'routes' => array(	
        		'about' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/about',
        						'defaults' => array (
        								'controller' => 'Web\Controller\About',
        								'action' => 'index'
        						)
        				)
        		),
        		'case' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/case',
        						'defaults' => array (
        								'controller' => 'Web\Controller\Case',
        								'action' => 'index'
        						)
        				)
        		),
        		'news' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/news',
        						'defaults' => array (
        								'controller' => 'Web\Controller\News',
        								'action' => 'index'
        						)
        				)
        		),
        		'professional' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/professional',
        						'defaults' => array (
        								'controller' => 'Web\Controller\Professional',
        								'action' => 'index'
        						)
        				)
        		),
        		'team' => array (
        				'type' => 'Literal',
        				'options' => array (
        						'route' => '/team',
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
