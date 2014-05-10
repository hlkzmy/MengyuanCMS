<?php

return array(
		
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
	
	
	
	
);
