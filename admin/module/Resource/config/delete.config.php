<?php
return array(

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
		)
		
		
		
);