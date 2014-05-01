<?php

return array(
		
    'resource.video.update' => array(

    				'columns' => array( 
        			//在列表中需要显示的字段

    							'upload_flag',
    						
		    					'file',
		    			
		    					'name',
		        		
		        				'speaker[name]',
		    			
		    					'video_sort_id',
    						
    							'video_label_id',
		    			
		    					'school_id',
		    			
				    			'description',
        		    ),
    		
    				'data' =>array(
    			
			     			  'videoModel'=> array(
			     			    					'type' =>'master',
			     			    		            'field'=> array(
			     			    		                			'name',
			     			    		                			'speaker',
			     			    		                			'video_sort_id',
			     			    		                			'description',
			     			    		            				'school_id'
			     			    		          				  )
			     			  ),
    						  'videoLabelModel'=>array(
    						  		
				    						  		'type'=> 'slave',
				    						  		'condition_field'=>'video_id',
				    						  		'query_field'=>'video_label_id'
    						  		
    						  		),
    						  
    						
    				),
    		
    				'additional_columns'=>array(
    						
    						 'video_sort_id'=>array(
    												 'type'=>'field_lookup',
    												 'model'=>'videoSortModel',
    												 'query_field'=>array('id','name'),
    												),
    						
    						 'school_id'	=>array(
    												 'type'=>'field_lookup',
    								                 'model'=>'areaModel',
    												 'query_field'=>array('id','name'),
    								                ),
    						 'speaker'=>array(
				    								
    												'type'=>'field_json_decode',
    								
				    						 ),
    						
    			   )//additional_columns end
    ),//information.user.update end
     
	'resource.videosort.update' => array(
	
			'columns' => array(
					//在列表中需要显示的字段
					'parent_id',
	
					'name',
					 
					'description',
	
			),
	
			'data' =>array(
					 
					'videoSortModel'=> array(
												'type' =>'master',
												'field'=> array('parent_id','name','description')
											),
					 
			),
			
			'additional_columns'=>array(
			
					'parent_id'=>array(
							'type'=>'field_lookup',
							'model'=>'videoSortModel',
							'query_field'=>array('id','name'),
							'handle_type'=>'string_connect'
					),
			
			),
	
	),//information.user.update end
	'resource.videolabel.update' => array(
	
	
			'columns' => array(
					'name',
					'description',
			),
			
			'data' =>array(
					
						'labelModel'=>array(
								'type' =>'master',
								'field'=> array('name','description')
								)
					
					
					),
	
	),//resource.videosort.create	
	'resource.article.update' => array(
	
			'columns' => array(
					//在列表中需要显示的字段
					
					'title',
					 
					'sub_title',
	
					'article_sort_id',
					 
					'keyword',
					 
					'content'
	
			),
	
			'data' =>array(
	
					'articleModel'=> array(
							'type' =>'master',
							'field'=> array('title','sub_title','article_sort_id','keyword')
					),
					
					'articleContentModel'=>array(
							'type'=>'master',
							'field'=> array('content')
					),
					
			),
			'additional_columns'=>array(
						
					'article_sort_id'=>array(
							'type'=>'field_lookup',
							'model'=>'articleSortModel',
							'query_field'=>array('id','name'),
					),
						
			),
	
	),//information.user.update end
	
	'resource.articlesort.update' => array(
		
				'columns' => array(
						//在列表中需要显示的字段
						'parent_id',
		
						'name',
		
						'description',
		
				),
		
				'data' =>array(
						
						'articleSortModel'=> array(
								
								'type' =>'master',
								'field'=> array('parent_id','name','description')
								
						),
				),
				'additional_columns'=>array(
				
						'parent_id'=>array(
								'type'=>'field_lookup',
								'model'=>'articleSortModel',
								'query_field'=>array('id','name'),
						),
				
				),
		
	),//information.user.update end
	
		
	'resource.courseware.update' => array(
	
			'columns' => array(
					//在列表中需要显示的字段
					'courseware',
					 
					'name',
	
					'courseware_sort_id',
					 
					'video_id',
					 
					'description',
			),
	
			'data' =>array(
					 
					'coursewareModel'=> array(
							'type' =>'master',
							'field'=> array(
									'name',
									'courseware_sort_id',
									'video_id',
									'description',
							)
					)
			
			
			),
			
			'additional_columns'=>array(
			
					'courseware_sort_id'=>array(
							'type'=>'field_lookup',
							'model'=>'coursewareSortModel',
							'query_field'=>array('id','name'),
					),
			
					'video_id'=>array(
							'type'=>'field_lookup',
							'model'=>'videoModel',
							'query_field'=>array('id','name'),
					),
			),
			
			
			
			
	
	),//information.user.update end
	 
	'resource.coursewaresort.update' => array(
	
			'columns' => array(
					//在列表中需要显示的字段
					'parent_id',
	
					'name',
	
					'description',
	
			),
	
			'data' =>array(
	
					'coursewareSortModel'=> array(
							
							'type' =>'master',
							
							'field'=> array('parent_id','name','description')
					),
	
			),
			
			'additional_columns'=>array(
						
					'parent_id'=>array(
							'type'=>'field_lookup',
							'model'=>'coursewareSortModel',
							'query_field'=>array('id','name'),
					),
						
			),
	
	),//information.user.update end
	
	
);
