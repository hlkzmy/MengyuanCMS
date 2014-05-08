<?php
return array(
		
		
		
		'not_need_auth_module' => array('application'),
         //不需要验证的模块
									
		'not_need_auth_controller' => array('application.index'),
		//不需要验证的控制器
				
		'not_need_auth_action' => array(
	    //不需要验证的方法	
				'application.index.showuserlogin',
				'application.index.checkuserlogin',
				'application.index.captcha',
				'application.index.logout',
				
		),
		
		'need_generate_menu' =>array(
				//需要生成菜单的方法列表
		
			'application.index.admin',
				 
			'application.index.sidebar',
				 
		),
		
		
);
