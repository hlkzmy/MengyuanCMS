<?php

return array(
            /*****首页显示页面*****/
    'router' => array(
        'routes' => array(			
           'information' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/information[/:controller][/:action][/:source][/:name][/][:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'information\Controller',
                        'controller'    => 'User',
                        'action'        => 'showUserList',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
			
        ),
    ),
	
	/*****添加新的控制器*****/
    'controllers' => array(
        'invokables' => array(
            'information\Controller\User' 			=> 'User\Controller\UserController',
        	'information\Controller\Role' 			=> 'User\Controller\RoleController',
        	'information\Controller\School' 		=> 'School\Controller\SchoolController',
        	'information\Controller\Academy'		=> 'School\Controller\AcademyController',
       ),
    ),
	/*****模版路径*****/
    'view_manager' => array(
        'template_path_stack' => array(
           'report'=>__DIR__ . '/../view',
        ),
    ),
);
