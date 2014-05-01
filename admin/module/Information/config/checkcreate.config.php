<?php
return array(	
		
	'information.user.checkcreate' => array(
				
				'preproccess'=>array(
						
				//对所有需要预处理的数据进行处理		
						'postdata' =>array(
										'getpassword',
										'checkSchool'
										
								),
				//运行一些前置的函数，先进行一些与数据无关的检验		
						'check'=>array(
								
								
								)
						
				),//end of preproccess
				
				'filter' =>array(
				
						'userFilter'=>array(
				
								'columns'=>array(
				
										'username'=>'',
				
										'realname'=>'',
				
										'password'=>'',
										
										'job_number'=>'',
				
										'id_card'=>'',
				
										'cellphone'=>'',
				
										'qq'=>'',
				
										'email'=>'',
										
										'school_id'=>array(
												'type'=>'map',
												'from'=>'school_school_id'
												),
				
										'work_type_id'=>'',
				
										'subject_id'=>'',
										
										'description'=>''
				
								),
						),
				
						'userRoleFilter'=>array(
								
										'columns'=>array(
												'role_id'=>''
										),
								
										'array_columns' =>array(
											'role_id'=>'' 	
										),
								)
				
				),//end of filter
				
				'model'=>array(
						
						'userModel'=>array(
						
								'type' =>'masterModel',
						
								'filter_name'=>'userFilter',
						
								'columns'=>array(
						
										'username'=>'',
						
										'realname'=>'',
						
										'password'=>array(
												'type' => 'md5'
												),
						
										'job_number'=>'',
						
										'id_card'=>'',
						
										'cellphone'=>'',
						
										'qq'=>'',
						
										'email'=>'',
										
										'school_id'=>'',
						
										'work_type_id'=>'',
						
										'subject_id'=>'',
										
										'description'=>''
		
								),
								'additional_columns' => array(
										
										
										'add_time' =>array(
												'type' =>'system',
												'function'	   =>'date',
												'parameter'=>'Y-m-d H:i:s'
										),
										'status' =>array(
												'type' =>'default',
												'value' =>'Y'
										),
								
								),
						),
						'userRoleModel'=>array(
						
								'type'=>'slaveModel',
						
								'filter_name'=>'userRoleFilter',
								
								'columns' =>array(
										//这里放的是普通的字段，不是重复字段，也不是主要字段。这些字段是会经过filter验证的
										//不经过filter验证的字段意味着不从postdata里面拿，写在additional_columns里面
										'role_id'=>'',
								),
						
								'array_columns' =>array(
										//这里放会重复的字段
										'role_id'=>'',
										
										),
								'master_columns' =>array(
										//这里放置必须出现的主要字段，例如用户角色表的用户id
										//这里这么写是为了跟edit的配置匹配和类似，方便以后自己写配置
										'user_id'=>array(
												'type' =>'parameter',
												'parameter'=>'lastInsertValue'
										),
										
								)
								
						)
						
				),//end of model
				
				
				'rehabilitation'=>array(
						//进行一些善后处理，对无限分类的部分进行伤口缝合
						
				 )//end of rehabilitation
				
				
			),
		
		
		'information.role.checkcreate' => array(
				
				
				'preproccess'=>array(
						
				//对所有需要预处理的数据进行处理		
						'postdata' =>array(

								),
				//运行一些前置的函数，先进行一些与数据无关的检验		
						'check'=>array(
								
								
								
								)
						
				),//end of preproccess
				
				'filter' =>array(
				
						'roleFilter'=>array(
				
								'columns'=>array(
				
										'name'=>'',
										
										'description'=>'',
										
										'parent_id'=>array(
												'type'=>'map',
												'from'  =>'video_parent_id'
												),

				
								),
						),
				
				
				),//end of filter
				
				'model'=>array(
						
						'roleModel'=>array(
						
								'type' =>'masterModel',
						
								'filter_name'=>'roleFilter',
						
								'columns'=>array(
						
										'name'=>'',
										
										'description'=>'',
										
										'parent_id'=>'',
		
								),
								'additional_columns' => array(
										
										'status' =>array(
												'type' =>'default',
												'value' =>'Y'
										),
								
								),
						),
						
				),//end of model
								
								
				'rehabilitation'=>array(
						//进行一些善后处理，对无限分类的部分进行伤口缝合
						
						array(
								'type' =>'sort',
								'model' =>'roleModel'
								)
						
				)//end of rehabilitation
		
		),
		
		'information.school.checkcreate' => array(
		
		
				'preproccess'=>array(
		
						//对所有需要预处理的数据进行处理
						'postdata' =>array(
		
						),
						//运行一些前置的函数，先进行一些与数据无关的检验
						'check'=>array(
		
		
		
						)
		
				),//end of preproccess
		
				'filter' =>array(
		
						'schoolFilter'=>array(
		
								'columns'=>array(
										
										'area_id'=>array(
												'type'=>'map',
												'from'=>'school_area_id'
												),
		
										'name'=>'',
										
										'school_sort_id'=>'',
		
										'address'=>'',
											
										'url'=>'',
										
										'leader_realname'=>'',
										
										'leader_cellphone'=>'',
										
										'description'=>'',
		
								),
						),
						'areaFilter'=>array(
						
								'columns'=>array(
									'name'=>'',
									'parent_id'=>array(
												'type'=>'map',											
												'from'=>'school_area_id'
											)
								),
						),
						
						
		
				),//end of filter
		
				'model'=>array(
		
						'schoolModel'=>array(
		
								'type' =>'masterModel',
		
								'filter_name'=>'schoolFilter',
		
								'columns'=>array(
		
										'name'=>'',
										
										'school_sort_id'=>'',
		
										'address'=>'',
										
										'url'=>'',
										
										'leader_realname'=>'',
										
										'leader_cellphone'=>'',
										
										'description'=>'',
		
								),
								'additional_columns' => array(
										
										'id'=>array(
												'type'=>'function',
												'function'=>'getSchoolId'
										),
										
										'status' =>array(
												'type' =>'default',
												'value' =>'Y'
										),
										'add_time'=>array(
												'type' =>'system',
												'function'=>'date',
												'parameter'=>'Y-m-d H:i:s'	
										),
		
								),
						),
						
						'areaModel'=>array(
						
								'type' =>'slaveModel',
						
								'filter_name'=>'areaFilter',
								
								'columns'=>array(
										
										'name'=>'',
										'parent_id'=>'',
										
								),
								'additional_columns' => array(
						
										'id'=>array(
												'type'=>'parameter',
												'parameter'=>'lastInsertValue'
										),
										
										'full_name'=>array(
												'type'=>'function',
												'function'=>'getFullName',
												),
										
										'status' =>array(
												'type' =>'default',
												'value' =>'Y'
										),
										
										'display' =>array(
												'type' =>'default',
												'value' =>'Y'
										),
						
								),
						),
		
				),//end of model
		
		
				'rehabilitation'=>array(
						//进行一些善后处理，对无限分类的部分进行伤口缝合
				
						array(
								'type'=>'sort',
								'model'=>'areaModel'
								)
						
						
				)//end of rehabilitation
		
		),//end of schooladd
		
		

);