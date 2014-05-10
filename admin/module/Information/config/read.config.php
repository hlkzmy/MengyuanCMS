<?php

return array(
		
    'information.user.read' => array(

    	'type'	  => 'filter',
    	//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
    
    	'layout_height'=>118,
    		
    	'master_model'=>'userModel',
    	//进行查询所对应的主表
    		
        'columns' => array(
        //在列表中需要显示的字段		
        		        'id'=>'',      
        		
        		        'realname'=>'',
        		
        				'email'=>'',
        		
        		        'add_time'=>'',
        		
        		        'status'=>'',
        		
        ),
    		
    	
		'additional_columns' => array(
    				//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
    				//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
    				'status_string'	 => 'getStatusString'
			
    	),
    		
    	'template_display_columns' => array(
    											'id'=>array(
    															'label'=>'编号',
    															'width'=>'60'
    														),
    											'realname'=>array(
    															'label'=>'用户姓名',
    														 ),
    			
    											'email'=>array(
    															'label'=>'电子邮箱',
    															'width'=>160
    														 ),
    											
    											'add_time'=>array(
    															'label'=>'添加时间',
    															'width'=>'160'
    														),
    			
    											'status_string'=>array(
    															'label'=>'用户状态',
    															'width'=>'160'
    														)
    			
    	),//template_display_columns end
    	
    	'pager_form' =>array(

    						'row_element_count'=>3,
    			
			    			'columns' => array(
			    			
			    					'id'=>array(
			    							'form_control'=>'text',
			    							'method'=>'eq',
			    					),
			    						
			    					'realname'=>array(
			    							'form_control'=>'text',
			    							'method'=>'like',
			    					)
			    					
			    			),//columns end
    			
    	),//pager_form end
    	
    	'pagination' =>array(
    			
    						'page_row_count'=>30,
    			
    						'select_value_options'=>array(
					    								'30'=>30,
					    								'60'=>60,
					    								'120'=>120,
					    								'240'=>240,
					    								'300'=>300,
    												)
    					
    	),//pagination end
    	
    	'operation_list'=>array(
    					
    				array(
    						'title'=>'添加用户',
    						'route'=>'information',
    						'route_parameter'=>array('controller'=>'user','action'=>'create'),
    						'target'=>'navTab'
    				),
    				array(
    						'title'=>'删除用户',
    						'route'=>'information',
    						'route_parameter'=>array('controller'=>'user','action'=>'delete'),
    						'param'=>'id',
    						'target'=>'ajaxTodo'
    				),
    				array(
    						'title'=>'编辑用户',
    						'route'=>'information',
    						'route_parameter'=>array('controller'=>'user','action'=>'update'),
    						'param'=>'id',
    						'target'=>'navTab'
    				),
    					
    	),//operation_list end
    									
    	            
    		               
    		
    		
    		
    ),//resource.video.read end
    
	'information.role.read' => array(
	
			'type'	  => 'unlimited',
			//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
	
			'root_id'=>1,
				
			'level'  =>4,
				
			'master_model'=>'roleModel',
	
			'select_control_type'=>'none',
			//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
			//如果不是这三个选项就报错
			'select_type'=>'leaf',	
			
			'post_url'=> 'getRoleListPostUrl',
	
			'columns' => array(
			//在列表中需要显示的字段
					'id'=>'',
	
					'name'=>'',
					
					'parent_id'=>'',
					
					'description'=>'',
	
					'left_number' =>'',
					
					'right_number'=>'',
				
					'level'=>'',
					
					'status'=>'',
	
			),
			
			'additional_columns' => array(
			//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
			//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录	
					
					'role_type'=> 'getSortType',
						
					'children_count' => 'getChildrenCount',
					
					'status_string'	 => 'getStatusString'
					
			),
			
			'template_display_columns' => array(
			
					'id'=>array(
							'label'=>'编号',
							'width'=>'60'
					),
					'name'=>array(
							'label'=>'分类名称',
					),
						
					'level'=>array(
							'label'=>'分类级别',
							'width'=>'80'
					),
						
					'role_type'=>array(
							'label'=>'分类类别',
							'width'=>'120'
					),
						
					'children_count'=>array(
							'label'=>'子分类数量',
							'width'=>'80'
					),
						
					'status_string'=>array(
							'label'=>'分类状态',
							'width'=>'80'
					),
						
			),//template_display_columns end
				
			'operation_list'=>array(
			
					array(
							'title'=>'添加角色',
							'route'=>'information',
							'route_parameter'=>array('controller'=>'role','action'=>'create'),
							'target'=>'navTab'
					),
					array(
							'title'=>'删除角色',
							'route'=>'information',
							'route_parameter'=>array('controller'=>'role','action'=>'delete'),
							'param'=>'id',
							'target'=>'ajaxTodo'
					),
					array(
							'title'=>'编辑角色',
							'route'=>'information',
							'route_parameter'=>array('controller'=>'role','action'=>'update'),
							'param'=>'id',
							'target'=>'navTab'
					),
			
			),//operation_list end
			
	),//resource.video.read end
	
	'information.school.read' => array(
	
			'type'	  => 'filter',
			//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
	
			'layout_height'=>140,
	
			'columns' => array(
					//在列表中需要显示的字段
					'id'=>'',
	
					'name'=>'',
	
					'address'=>'',
	
					'school_sort_id' =>array(
        										'type' =>'query',
        										'model'=>'schoolSortModel',
        										'query_field' =>'id',
        										'result_field'=>'name'
        			),
					
					'leader_realname'=>'',
					
					'leader_cellphone'=>'',
	
					'add_time'=>'',
	
					'status'=>'',
	
			),
	
			'master_model'=>'schoolModel',
			//进行查询所对应的主表
	
	
			'additional_columns' => array(
					//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
					//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
					'status_string'	 => 'getStatusString'
	
			),
			
			'pager_form' =>array(
			
					'row_element_count'=>3,
					 
					'columns' => array(
			
							'id'=>array(
									'form_control'=>'text',
									'method'=>'eq',
							),
							 
							'name'=>array(
									'form_control'=>'text',
									'method'=>'like',
							),
							
							'address'=>array(
									'form_control'=>'text',
									'method'=>'like',
							),
								
							'leader_realname'=>array(
									'form_control'=>'text',
									'method'=>'like',
							),
								
							'leader_cellphone'=>array(
									'form_control'=>'text',
									'method'=>'like',
							),
							
							
			
					),//columns end
					 
			),//pager_form end
			
			'template_display_columns' => array(
						
					'id'=>array(
							'label'=>'编号',
							'width'=>'120'
					),
					
					'name'=>array(
							'label'=>'学校名称',
					),
					
					'address'=>array(
							'label'=>'学校地址'		
					),
					
					'leader_realname'=>array(
							'label'=>'学校负责人'	
					),
					
					'leader_cellphone'=>array(
							'label'=>'联系方式'
					),
			
			),//template_display_columns end
			
			'pagination' =>array(
					 
					'page_row_count'=>30,
					 
					'select_value_options'=>array(
							'30'=>30,
							'60'=>60,
							'120'=>120,
							'240'=>240,
							'300'=>300,
					)
						
			),//pagination end
			
			'operation_list'=>array(
						
					array(
							'title'=>'添加学校',
							'route'=>'information',
							'route_parameter'=>array('controller'=>'school','action'=>'create'),
							'target'=>'navTab'
					),
					array(
							'title'=>'删除学校',
							'route'=>'information',
							'route_parameter'=>array('controller'=>'school','action'=>'delete'),
							'param'=>'id',
							'target'=>'ajaxTodo'
					),
					array(
							'title'=>'编辑学校',
							'route'=>'information',
							'route_parameter'=>array('controller'=>'school','action'=>'update'),
							'param'=>'id',
							'target'=>'navTab'
					),
						
			)//operation_list end
	
			
	
	),//resource.video.read end
    
        
    
);
