<?php

return array(
		
    'information.user.create' => array(

    	'form'=>'userForm',
    	//进行查询所对应的主表
    		
    	'columns' => array(
        //在列表中需要显示的字段	
    		
        		        'username'=>array(
    										'label'=>'用户名',
    										'form_control'=>'text'
    								),
    			
    					'realname'=>array(
        		        					'label'=>'用户姓名',
    										'form_control'=>'text'
        		        		   ),
    					'job_number'=>array(
    										'label'=>'工号',
    										'form_control'=>'text'
    							   ),
        		
        				'password'=>array(
        		        					'label'=>'用户密码',
        									'form_control'=>'password'
        		        		  	),
    			
    					'confirm_password'=>array(
    										'label'=>'确认密码',
    										'form_control'=>'password'
    								),
    			
    			
    					'id_card'=>array(
    										'label'=>'身份证号码',
    										'form_control'=>'text',
    										'attribute'=>array(
    														'size'=>40
    													)
    								),
    			
		    			'cellphone'=>array(
					    					'label'=>'手机号码',
		    								'form_control'=>'text'
		    			            ),
    			
		    			'qq'=>array(
					    					'label'=>'QQ号码',
		    								'form_control'=>'text'
		    						),
        		
		    			'email'=>array(
		    								'label'=>'电子邮箱',
		    								'form_control'=>'text'
		    			 			),
    			
		    			'school_id'=> array(
		    					'label'=>'所在学校',
		    					'form_control'=>'Dwzlookup',
		    					'attribute'=>array(
		    							'href'=>'#',
		    							'lookupgroup'=>'school',
		    							'name'=>'school_id',
		    							'width'=>'700',
		    							'height'=>'500',
		    							'label'=> '选择用户所属的学校',
		    							'size'=>'40'
		    					)
		    			),
    			
    					'work_type_id'=>array(
    										'label'=>'工作类型',
    										'form_control'=>'Select',
    										'options'=>array(
    												       'model'=>'workTypeModel',
    													   'field'=>array('id','name'),
    													   'function'=>'getRowList'
    												)
    								),
    			
		    			'subject_id'=>array(
		    								'label'=>'主讲科目',
		    								'form_control'=>'select',
		    								'options'=>array(
    												       'model'=>'subjectModel',
    													   'field'=>array('id','name'),
    													   'function'=>'getRowList'
    												)
		    						),
		    			'role_id'=>array(
		    								'label'=>'用户角色',
		    								'form_control'=>'MultiCheckbox',
		    								'options'=>array(
    												       'model'=>'roleModel',
    													   'field'=>array('id','name'),
    													   'function'=>'getRowList',
		    												'defaultValue'=>false,
    												)
		    						),
    			
						'description'=>array(
											'label'=>'个人简介',
        									'form_control'=>'textarea',
        									'attribute'=>array(
        													'rows'=>8,
        													'cols'=>60
        												)
						),
        		        
        			),
    		
    		
    		
    		'additional_columns' => array(
    		
    					
    				'school_id'  	=> array(
    						'href'=>array(
    								'function'=>'getSchoolIdLookupHref'
    						)
    				),
    					
    		)
    		
     ),//information.user.create end
    
	'information.role.create' => array(
		
				'form'=>'roleForm',
				//进行查询所对应的主表
		
				'columns' => array(
						//在列表中需要显示的字段
						'parent_id'=>array(
								'label'=>'父级角色',
								'form_control'=>'DwzLookup',
								'attribute'=>array(
													'href'=>'#',
													'lookupgroup'=>'video',
													'name'=>'parent_id',
													'width'=>'700',
													'height'=>'500',
													'label'=> '选择角色所从属的父分类',
													'size'=>'60'
											)
						),
						
						'name'=>array(
								'label'=>'角色名称',
								'form_control'=>'text'
						),
						
						'description'=>array(
								'label'=>'角色描述',
								'form_control'=>'textarea',
								'attribute'=>array(
										'rows' =>'10',
										'cols' =>'80'
								)
						),
						
				),
			
			 'additional_columns' => array(
			
					'parent_id'  => array(
							'href'=>array('function'=>'getParentIdLookupHref')
					),
			 )
		
	),//information.role.create
	
	'information.school.create' => array(
		
				'form'=>'schoolForm',
				//进行查询所对应的主表
		
				'columns' => array(
						//在列表中需要显示的字段
						'area_id'=>array(
								'label'=>'所在区域',
								'form_control'=>'DwzLookup',
								'attribute'=>array(
    												'href'=>'#',
    												'lookupgroup'=>'school',
    												'name'=>'area_id',
    												'width'=>'800',
    												'height'=>'500',
    												'label'=> '选择学校所在的地域',
    												'size'=>'60'
    											)
						),
		
						'name'=>array(
											'label'=>'学校名称',
											'form_control'=>'text'
									 ),
		
						'school_sort_id'=>array(
											'label'=>'学校类型',
											'form_control'=>'select',
											'options'=>array(
													'model'=>'schoolSortModel',
													'field'=>array('id','name'),
													'function'=>'getRowList'
											)
						),
						'address'=>array(
											'label'=>'学校地址',
											'form_control'=>'text',
											'attribute'=>array(
																'size'=>60
													
														 )
											
						),
						'url'=>array(
								'label'=>'校级资源平台地址',
								'form_control'=>'text',
						),
						'leader_realname'=>array(
											'label'=>'法人代表',
											'form_control'=>'text',
						),
						'leader_cellphone'=>array(
											'label'=>'联系方式',
											'form_control'=>'text',
						),
						
						'description'=>array(
											'label'=>'学校简介',
        									'form_control'=>'textarea',
        									'attribute'=>array(
        													'rows'=>8,
        													'cols'=>60
        												)
						),
						
						
				),
			
				'additional_columns' => array(
				
						'area_id'=> array(
						
								'href'=>array(
										'function'=>'getAreaIdLookupHref'
					
								)
						),
							
				)
		
	),//information.role.create
    
        
    
);
