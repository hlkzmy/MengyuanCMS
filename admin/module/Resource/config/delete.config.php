<?php
return array(

		
		'resource.video.delete' => array(
				
				'check_before_delete'  => array(

						
						),
				'master_model'=>array(
						'model'=>'videoModel',
						'filter' => array(
								'filter_name'=>'videoFilter' ,
								'filter_field' =>array('id')
						)
				),
				
				
				'slave_model' => array(
				
						'videoFilterModel'=>array(
													'field'=>'id'
										   ),
						'videoPlayinfoModel'=>array(
													'field'=>'id'
											),
						'videoLabelModel'=>array(
													'field'=>'video_id',
								)
				),
		
		),//resource.video.delete
		
		
		'resource.videosort.delete' => array(
		
				'check_before_delete'  => array(
		
						array(
								'type'  =>'sort',
								'message'=>'该分类下存在其他小分类，无法删除'
								)
						),
		
				'master_model'=>array(
						'model'=>'videoSortModel',
						'filter' => array(
								'filter_name'=>'videoSortFilter' ,
								'filter_field' =>array('id')
						)
				),
				
				'slave_model' => array(),
				
				'check_after_delete'   =>array(
						array(
								'type'  =>'sort'
								)
						)
		
				),//endof resource.videosort.delete
		
		'resource.courseware.delete' => array(
		
				'check_before_delete'  => array(
		
		
				),
				'master_model'=>array(
						'model'=>'coursewareModel',
						'filter' => array(
								'filter_name'=>'courswareFilter' ,
								'filter_field' =>array('id')
						)
				),
				
		),
		
		'resource.coursewaresort.delete' => array(
				
				'check_before_delete'  => array(
				
						array(
								'type'  =>'sort',
								'message'=>'该分类下存在其他小分类，无法删除'
						)
				),
				'master_model'=>array(
						'model'=>'coursewareSortModel',
						'filter' => array(
								'filter_name'=>'courswareSortFilter' ,
								'filter_field' =>array('id')
						)
				),
				'check_after_delete'   =>array(
						array(
								'type'  =>'sort'
						)
				)
		),
		
		'resource.article.delete' => array(
		
				'check_before_delete'  => array(
		
		
				),
				'master_model'=>array(
						'model'=>'articleModel',
						'filter' => array(
								'filter_name'=>'articleFilter' ,
								'filter_field' =>array('id')
						)
				),
				'slave_model' => array(
						
						'articleContentModel'=>array(
								
								'field'=>'id',
								
								)
						
						),
		
		),
		
		'resource.articlesort.delete' => array(
				
				'check_before_delete'  => array(
				
						array(
								'type'  =>'sort',
								'message'=>'该分类下存在其他小分类，无法删除'
						)
				),
				'master_model'=>array(
						'model'=>'articleSortModel',
						'filter' => array(
								'filter_name'=>'articleSortFilter' ,
								'filter_field' =>array('id')
						)
				),
				'check_after_delete'   =>array(
						array(
								'type'  =>'sort'
						)
				)
		),
		'resource.videolabel.delete' => array(
		
				'check_before_delete'  => array(
		
				),
				'master_model'=>array(
						'model'=>'labelModel',
						'filter' => array(
								'filter_name'=>'labelFilter' ,
								'filter_field' =>array('id')
						)
				),
				
				'slave_model' => array(
				
						'videoLabelModel'=>array(
				
								'field'=>'video_label_id',
				
						)
				
				),
				
		),
		
		
		
		
		
);