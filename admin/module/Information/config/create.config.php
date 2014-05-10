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
	
	
);
