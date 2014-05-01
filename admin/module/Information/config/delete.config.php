<?php
return array(

		'test.test.delete' => array(
		
		
				'check_before_delete'  => array(
		
						array(
								'type'  =>'sort',
								'message'=>'该分类下存在其他小分类，无法删除'
						),
						array(
										'type'  =>'status',
										'field'=>'status',
										'equal' => true,              //该字段表示等于则为真
										'value' => 'Y',
										'message'=>''
										),
						array(
										'type'  =>'query',
				                        'field' =>array('user_id'),
										'model' =>'user',
										'exist'  => true,              //该字段表示存在为真
										'message'=>''
										),
						
						array(
										'type' =>'action',
								        'action_name'=>'abc',
										'message'=>''
								)
		
				),
		
				'master_model'=>array(
											'model'=>'videoSortModel',
											'filter' => array(
														'filter_name'=>'userRoleFilter' ,
														'filter_field' =>array('id')
														)
						),
		
				'slave_model' => array(
										'userRoleModel'=>array(
															'field'=>'user_id',
															'filter'=>array(
																	'filter_name'=>'userRoleFilter' ,
																	'filter_field' =>array('id')
																	)
														)
				),
		
				'check_after_delete'   =>array(
						array(
								'type'  =>'sort'
						)
				)
		
		),		
		
		
		
		'information.user.delete' => array(
				
				'check_before_delete'  => array(

						),
				
				'master_model'=>array(
						'model'=>'userModel',
						'filter' => array(
								'filter_name'=>'userFilter' ,
								'filter_field' =>array('id')
						)
				),
				
				'slave_model' => array(
							'userRoleModel'=>array(
								'field'=>'user_id',
							)
				),
				
		),
		
		'information.role.delete' => array(
		
				'check_before_delete'  => array(
						array(
								'type'  =>'query',
								'field' => 'role_id',
								'model' =>'userRoleModel',
								'exist'  => true,              //该字段表示存在为true
								'message'=>'有用户从属于该角色，无法删除'
						)
						
				),
		
				'master_model'=>array(
							'model'=>'roleModel',
							'filter' => array(
										'filter_name'=>'roleFilter' ,
										'filter_field' =>array('id')
										)
						),
		
				'slave_model' => array(
							'userRoleModel'=>array(
									'field'=>'role_id',
							)
						),
				
				'check_after_delete'   =>array(
						array(
								'type'  =>'sort'
						)
				)
			),
		'information.school.delete' => array(
		
				'check_before_delete'  => array(
		
				),
		
				'master_model'=>array(
						'model'=>'areaModel',
						'filter' => array(
								'filter_name'=>'areaFilter' ,
								'filter_field' =>array('id')
						)
				),
		
				'slave_model' => array(
						'schoolModel'=>array(
								'field'=>'id',
						)
				),
		
				'check_after_delete'   =>array(
						array(
								'type'  =>'sort'
						)
				)
		)		
		
		
		

);