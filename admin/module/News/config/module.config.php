<?php

return array(
		
    /*****首页显示页面*****/
    'router' => array(
        'routes' => array(			
            'news' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/news[/:controller][/][:action][/][:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    	'id'=> '[0-9+]',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'News\Controller',
                        'controller'    => 'Article',
                        'action'        => 'list',
                    ),
                ),
            ),
			
        ),
    ),
	
	/*****添加新的控制器*****/
    'controllers' => array(
        'invokables' => array(
        	'News\Controller\Article'    => 'Help\Controller\ArticleController',
        	'News\Controller\ArticleSort'=> 'Help\Controller\ArticleSortController'
        ),
    ),
	/*****模版路径*****/
    'view_manager' => array(
        'template_path_stack' => array(
           'help'=>__DIR__ . '/../view',
        ),
    ),
);
