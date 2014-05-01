<?php

return array(
		
	'router' => array(
			
        'routes' => array(	
        	'help' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/help[/:controller][/:action]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Help\Controller',
                        'controller'    => 'Article',
                        'action'        => 'index',
                    ),
                	
                		
                ),
            ),
			
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
        	'Help\Controller\Index'   => 'Help\Controller\IndexController',
            'Help\Controller\Article' => 'Help\Controller\ArticleController'
        ),
     ),
	'view_manager' => array(
			'template_path_stack' => array(
					'help'=>__DIR__ . '/../view',
			),
	),
   
);
