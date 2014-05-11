<?php

return array(
		
	'router' => array(
			
		 'routes' => array(
		 		
		 		//文章内容的路由,经过这个路由，由文章id查询到文章的内容
				'article-content-route' => array(
		 			'type'    => 'Segment',
		 			'options' => array(
		 				'route'    => '/article-[:id].html',
		 				'constraints' => array(
		 						'id'  => '[1-9]{1}[0-9]*'
		 				),
		 				'defaults' => array(
		 						'__NAMESPACE__' => 'Web\Controller',
		 						'controller'    => 'News',
		 						'action'        => 'content',
		 				),
		 			)//option
		 		),//article-content-route
				
				//文章分类的路由,经过这个路由,由文章id查询到文章的内容
				'article-category-route' => array(
						'type'    => 'Segment',
						'options' => array(
								'route'    => '/category-[:id].html',
								'constraints' => array(
										'id'  => '[1-9]{1}[0-9]*'
								),
								'defaults' => array(
										'__NAMESPACE__' => 'Web\Controller',
										'controller'    => 'News',
										'action'        => 'category',
								),
						)//option
				)//category-content-route
		 	
		 )//routes end
	),
		
	'view_manager' => array(
		'template_path_stack' => array(
					'cms'=> dirname(__DIR__) . '/src',  
		 ),
	)
		
);

