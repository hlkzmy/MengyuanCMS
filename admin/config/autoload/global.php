<?php

return array(
		
		'not_need_auth_module' => array('application'),
         //不需要验证的模块
									
		'not_need_auth_controller' => array('application.index'),
		//不需要验证的控制器
				
		'not_need_auth_action' => array(
	    //不需要验证的方法	
				'admin.index.showuserlogin',
				'admin.index.checkuserlogin',
				'admin.index.captcha',
				'admin.index.logout',
				
		),
		
		'need_generate_menu' =>array(
		//需要生成菜单的方法列表
		
			'admin.index.console',
				 
			'admin.index.sidebar',
				 
		),
		
		'template_upload'=>array (
				'max_size' => '5MB', // 上传文件的最大尺寸
				'ext' =>'xls,xlsx', 
				'dir' => BASEPATH. '/public/ReportTemplate/' 
		),
		
		
		//视频缩略图的尺寸的列表
		'video_thumb_size_list' =>array(
										"640x480",
										"426x320",
										"150x113",
										"116x87",
										"64x48"
		)
		
		
		
		
		
);
