<?php

return array(
		
    'information.user.update' => array(

    	'columns' => array( 
        //在列表中需要显示的字段	
//     						'username',
	    			
	    					'realname',
    			
//     						'job_number',
	        		
	    					'realname',
	    			
	    					'cellphone',
	    			
			    			'qq',
	        		
			    			'email',
    			
    						'school_id',
	    			
	    					'work_type_id',
	    			
			    			'subject_id',
	    			
			    			'role_id',
    			
    						'description'
        		    ),
    		
    				'data' =>array(
    			
			     			    	'userModel'	   => array(
			     			    						 'type' =>'master',
			     			    		                 'field'=> array('realname','school_id','qq','cellphone','email','work_type_id','subject_id','description')
			     			    				  ),
    			
				    				'userRoleModel'=> array(
				    									 'type'=> 'slave',
				    									 'condition_field'=>'user_id',
				    									 'query_field'=>'role_id'
				    				),
    			
    			 ),
    		'additional_columns' => array(
    					
    				'school_id'  	=> array(
    						'type'=>'field_lookup',
    						'model'=>'schoolModel',
    						'query_field'=>array('id','name'),
    				),
    	
			)
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
