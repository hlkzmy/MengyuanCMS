<?php

return array(
		
    'resource.article.lookup'  =>array(
				'resource.article.create' =>array(
		
						'article_sort_id'=>array(
									
								'type'	 => 'unlimited',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
									
								'root_id'=>1,
								//无限分类列表的数据从哪个节点开始查找，节点的id
									
								'level'  =>3,
								//无限分类列表初始化页面的时候查询多少级别以内的节点
									
								'master_model'=>'articleSortModel',
								//形成列表的数据表
									
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
									
								'select_type'=>'leaf',
								//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
								//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
									
								'post_url'=> 'getArticleSortIdLookupPostUrl',
								//得到由video_sort_id触发的查找带回的请求的网址，且只在type的取值为unlimited的时候生效
									
								'columns' => array(
										//在列表中需要显示的字段
		
										'id'=>'',
		
										'name'=>'',
		
										'description'=>'',
		
										'left_number' =>'',
											
										'right_number'=>'',
											
										'parent_id'=>'',
		
										'level'=>'',
		
										'status'=>'',
		
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
												'width'=>'100'
										),
											
										'children_count'=>array(
												'label'=>'子分类数量',
												'width'=>'100'
										)
											
								),//template_display_columns end
									
		
								'additional_columns' => array(
										//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
										//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
		
										'children_count'=> 'getChildrenCount',
								),
						),
		
				),
		
		),						
		'resource.articlesort.lookup'  =>array(
				'resource.articlesort.create' =>array(
		
						'parent_id'=>array(
									
								'type'	 => 'unlimited',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
									
								'root_id'=>1,
								//无限分类列表的数据从哪个节点开始查找，节点的id
									
								'level'  =>3,
								//无限分类列表初始化页面的时候查询多少级别以内的节点
									
								'master_model'=>'articleSortModel',
								//形成列表的数据表
									
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
									
								'select_type'=>'both',
								//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
								//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
									
								'post_url'=> 'getArticleSortIdLookupPostUrl',
								//得到由video_sort_id触发的查找带回的请求的网址，且只在type的取值为unlimited的时候生效
									
								'columns' => array(
										//在列表中需要显示的字段
		
										'id'=>'',
		
										'name'=>'',
		
										'description'=>'',
		
										'left_number' =>'',
											
										'right_number'=>'',
											
										'parent_id'=>'',
		
										'level'=>'',
		
										'status'=>'',
		
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
												'width'=>'100'
										),
											
										'children_count'=>array(
												'label'=>'子分类数量',
												'width'=>'100'
										)
											
								),//template_display_columns end
									
		
								'additional_columns' => array(
										//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
										//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
		
										'children_count'=> 'getChildrenCount',
								),
						),
		
				),
		
		),	
);
