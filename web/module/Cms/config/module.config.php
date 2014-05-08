<?php

return array(
		
	'router' => array(
		 'routes' => array(
				'article-content-route' => array(//文章内容路由
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
		 		),
		 	),
		 )//routes end
	),
		
	'view_manager' => array(
		'template_path_stack' => array(
				'cms'=> dirname(__DIR__) . '/src',  
		 ),
	),
		
		
   
	
		
);
