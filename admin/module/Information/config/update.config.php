<?php

return array(
		
    'information.user.update' => array(

    	'columns' => array( 
        //在列表中需要显示的字段	
							'realname',
    			
    						'cellphone',
	    			
			    			'qq',
	        		
			    			'email',
    			
    						'role_id',
    			
    						'description'
        		    ),
    		
    				'data' =>array(
    			
			     			    	'userModel'	   => array(
			     			    						 'type' =>'master',
			     			    		                 'field'=> array('realname','qq','cellphone','email','description')
			     			    				  ),
    			
				    				'userRoleModel'=> array(
				    									 'type'=> 'slave',
				    									 'condition_field'=>'user_id',
				    									 'query_field'=>'role_id'
				    				),
    			
    			 ),
    		
     ),//information.user.update end
     
	'information.role.update' => array(
	
			'columns' => array(
					//在列表中需要显示的字段
					'parent_id',
	
					'name',
					 
					'description',
	
			),
	
			'data' =>array(
					 
					'roleModel'	   => array(
							'type' =>'master',
							'field'=> array('parent_id','name','description')
					),
					 
			),
			'additional_columns' => array(
						
					'parent_id'  	=> array(
							'type'=>'field_lookup',
							'model'=>'roleModel',
							'query_field'=>array('id','name'),
					),
					 
			)
	
	),//information.user.update end
	
	'information.school.update' => array(
	
			'columns' => array(
					
		
						'name',
		
						'school_sort_id',
						
						'address',
					
						'url',
					
						'leader_realname',
					
						'leader_cellphone',
					
						'description',
	
			),
	
			'data' =>array(
	
					'schoolModel'=> array(
							
							'type' =>'master',
							
							'field'=> array('name','school_sort_id','address','leader_realname','leader_cellphone','description','url')
							
					),
	
			)
	
	),//information.user.update end
    
	
);
