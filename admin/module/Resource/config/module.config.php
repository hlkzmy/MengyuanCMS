<?php

return array(
		
    /*****首页显示页面*****/
    'router' => array(
        'routes' => array(			
            'resource' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/resource[/:controller][/:action][/:source][/:name][/][:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    	'source'	 => '([a-z]+[\.]){2}[a-z]+',
                    	'name'		 => '[a-z_]*',
                    	'id'         => '[0-9+]',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Resource\Controller',
                        'controller'    => 'Video',
                        'action'        => 'Read',
                    ),
                ),
            ),
			
        ),
    ),
	
	/*****添加新的控制器*****/
    'controllers' => array(
        
    	'invokables' => array(
        		
        	'Resource\Controller\Article'    		=> 'Article\Controller\ArticleController',
        	'Resource\Controller\ArticleSort'		=> 'Article\Controller\ArticleSortController',
        	
         ),
    ),
	/*****模版路径*****/
    'view_manager' => array(
        'template_path_stack' => array(
            'Resource'=>__DIR__ . '/../view',
        ),
    ),
);
