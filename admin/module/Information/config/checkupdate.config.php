<?php
return array(	
		
		'information.user.checkupdate' => array(
				
				'filter' =>array(
				
						'userFilter'=>array(
				
								'columns'=>array(
										
										'id'     =>'',
				
										'realname'=>'',
				
										'id_card'=>'',
				
										'cellphone'=>'',
				
										'qq'=>'',
				
										'email'=>'',
				
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
										
										
						
										'realname'=>'',
						
										'cellphone'=>'',
						
										'qq'=>'',
						
										'email'=>'',
						
										'description'=>''
		
								),
						),
						'userRoleModel'=>array(
						
								'type'=>'slaveModel',
						
								'filter_name'=>'userRoleFilter',
								
								'columns' =>array(
										
										'role_id'=>''
								),
						
								'array_columns' =>array(
										
										'role_id'=>'',
										
										),
								'master_columns' =>array(
										
										'user_id'=>array(
												'type' =>'parameter',
												'parameter'=>'updateId'
										),
										
										)
								
						)
						
				),//end of model
				
				
				
				'file' =>array(
						
						),//end of file
								
			),
		
		'information.role.checkupdate' => array(
				
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
										
										'id'=>'',
										
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
						),
						
				),//end of model
				
				
				'rehabilitation'=>array(
						//进行一些善后处理，对无限分类的部分进行伤口缝合
				
						array(
								'type' =>'sort',
								'model' =>'roleModel',
								'filter'=>'roleFilter'
						)
				
				)//end of rehabilitation
								
			),
		
		'information.school.checkupdate' => array(
		
		
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
										
										'id'=>'',
		
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
										
										'id'=>'',
										'name'=>'',
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
						),
		
						'areaModel'=>array(
		
								'type' =>'slaveModel',
		
								'filter_name'=>'areaFilter',
		
								'columns'=>array(
		
										'name'=>'',
		
								),
								'additional_columns' => array(
		
										'full_name'=>array(
												'type'=>'function',
												'function'=>'getFullName',
										),
								),
						),
		
				),//end of model
		
		
				'rehabilitation'=>array(
						//进行一些善后处理，对无限分类的部分进行伤口缝合
		
				)//end of rehabilitation
		
		),//end of schooledit

);