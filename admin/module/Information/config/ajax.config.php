<?php

return array(
		
		
	'information.user.lookup'  =>array(
	
			'information.user.create' =>array(
						'school_id'=>array(
						
								'type'	 => 'unlimited',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
						
								'root_id'=>1000,
								//无限分类列表的数据从哪个节点开始查找，节点的id
						
								'level'  =>2,
								//无限分类列表初始化页面的时候查询多少级别以内的节点
						
								'master_model'=>'areaModel',
								//形成列表的数据表
						
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
						
								'select_type'=>'leaf',
								//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
								//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
						
								'post_url'=> 'getSchoolIdLookupPostUrl',
								//得到由video_sort_id触发的查找带回的请求的网址，且只在type的取值为unlimited的时候生效
						
								'columns' => array(
										//在列表中需要显示的字段
										 
										'id'=>'',
										 
										'name'=>'',
										 
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
								 
						),//video_sort_id setting end
					)
	),
		
    'information.school.lookup'  =>array(

    	'information.school.create' =>array(
    			
    			'area_id'=>array(
    					
    					'type'	 => 'unlimited',
						//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
    			
    					'root_id'=>1000,
    					//无限分类列表的数据从哪个节点开始查找，节点的id
    					
    					'level'  =>2,
    					//无限分类列表初始化页面的时候查询多少级别以内的节点
    					
    					'master_model'=>'areaModel',
    					//形成列表的数据表
    			
    					'select_control_type'=>'radio',
    					//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
    			        //如果不是这三个选项就报错
    					
    					'select_type'=>'both',
    					//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
    					//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
    					
    					'post_url'=> 'getAreaIdLookupPostUrl',
    					//得到由video_sort_id触发的查找带回的请求的网址，且只在type的取值为unlimited的时候生效
    					
    					'columns' => array(
						//在列表中需要显示的字段
						
								'id'=>'',
				
								'name'=>'',
								
				
								'left_number' =>'',
    							
    							'right_number'=>'',
    							
    							'parent_id'=>'',
    							 
								'level'=>'',
								
								'status'=>'',
				
						),
						
    					'template_display_columns' => array(
    							
    							'id'=>array(
    									'label'=>'编号',
    									'width'=>'80'
    							),
    							'name'=>array(
    									'label'=>'分类名称',
    							),

    							'level'=>array(
    									'label'=>'分类级别',
    									'width'=>'100'
    							),
    							
    							'video_sort_type'=>array(
    									'label'=>'分类类别',
    									'width'=>'80'
    							),
    							
    							'children_count'=>array(
    									'label'=>'子分类数量',
    									'width'=>'100'
    							)
    							
    					),//template_display_columns end
    					
    						
						'additional_columns' => array(
						//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
						//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录	
								'video_sort_type'=> 'getSortType',
								
								'children_count'=> 'getChildrenCount',
						),
    					
    					'query_condition'=>array(
    							//对于无限分类列表的查询限定条件，因为有限定选择范围的问题
    							'level' =>array('type'=>'custom','method'=>'elt','field'=>'3')
    							//键名为master数据库中的字段名称，id为传进来的参数的名称
    					)
						
				),//area_id setting end
				
    			'school_id'=>array(
    						
    					'type'	 => 'unlimited',
    					//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
    					 
    					'root_id'=>1000,
    					//无限分类列表的数据从哪个节点开始查找，节点的id
    						
    					'level'  =>2,
    					//无限分类列表初始化页面的时候查询多少级别以内的节点
    						
    					'master_model'=>'areaModel',
    					//形成列表的数据表
    					 
    					'select_control_type'=>'radio',
    					//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
    					//如果不是这三个选项就报错
    						
    					'select_type'=>'leaf',
    					//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
    					//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
    						
    					'post_url'=> 'getSchoolIdLookupPostUrl',
    					//得到由video_sort_id触发的查找带回的请求的网址，且只在type的取值为unlimited的时候生效
    						
    					'columns' => array(
    							//在列表中需要显示的字段
    			
    							'id'=>'',
    			
    							'name'=>'',
    			
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
    			
    			),//video_sort_id setting end
    			
    		),//resource.video.create  触发页面结束
    	
    ),//resource.video.lookup  lookup类型的页面结束
    
		
	'information.role.lookup'  =>array(
		
				'information.role.create' =>array(
						 
						'parent_id'=>array(
									
								'type'	 => 'unlimited',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
								 
								'root_id'=>1,
								//无限分类列表的数据从哪个节点开始查找，节点的id
									
								'level'  =>5,
								//无限分类列表初始化页面的时候查询多少级别以内的节点
									
								'master_model'=>'roleModel',
								//形成列表的数据表
								 
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
									
								'select_type'=>'both',
								//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
								//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
									
								'post_url'=> 'getRoleListPostUrl',
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
											
										'video_sort_type'=>array(
												'label'=>'分类类别',
												'width'=>'80'
										),
											
										'children_count'=>array(
												'label'=>'子分类数量',
												'width'=>'100'
										)
											
								),//template_display_columns end
									
		
								'additional_columns' => array(
										//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
										//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
										'video_sort_type'=> 'getSortType',
		
										'children_count'=> 'getChildrenCount',
								),
		
						),//video_sort_id setting end
		
				),//resource.video.create  触发页面结束
	
		),//resource.video.lookup  lookup类型的页面结束
		'resource.courseware.lookup'  =>array(
		
				'resource.courseware.create' =>array(
							
						'courseware_sort_id'=>array(
									
								'type'	 => 'unlimited',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
									
								'root_id'=>1,
								//无限分类列表的数据从哪个节点开始查找，节点的id
									
								'level'  =>3,
								//无限分类列表初始化页面的时候查询多少级别以内的节点
									
								'master_model'=>'coursewareSortModel',
								//形成列表的数据表
									
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
									
								'select_type'=>'leaf',
								//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
								//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
									
								'post_url'=> 'getCoursewareSortIdLookupPostUrl',
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
						),//courseware_sort_id setting end
						
						'video_id'=>array(
								
								
								'type'	 => 'filtered',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
									
								'master_model'=>'videoModel',
								//形成列表的数据表
									
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
									
								'layout_height'=>116,
								
								'columns' => array(
										//在列表中需要显示的字段
								
										'id'=>'',
								
										'name'=>'',
								
								
								),
								
								'template_display_columns' => array(
											
										'id'=>array(
												'label'=>'编号',
												'width'=>'60'
										),
										'name'=>array(
												'label'=>'视频名称',
										),
								
											
								),//template_display_columns end
								
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
								
							),//video_id end
						
		
				),//resource.courseware.create  触发页面结束
				
		),				
		'resource.coursewaresort.lookup'  =>array(
				'resource.coursewaresort.create' =>array(
				
						'parent_id'=>array(
									
								'type'	 => 'unlimited',
								//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
									
								'root_id'=>1,
								//无限分类列表的数据从哪个节点开始查找，节点的id
									
								'level'  =>3,
								//无限分类列表初始化页面的时候查询多少级别以内的节点
									
								'master_model'=>'coursewareSortModel',
								//形成列表的数据表
									
								'select_control_type'=>'radio',
								//列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
								//如果不是这三个选项就报错
									
								'select_type'=>'both',
								//是否只在叶子节点上显示的选择控件,因为有的时候只能选择在叶子节点上，有的时候每个层级上都要能选择
								//此选项只有leaf和both两种取值，且只在select_control_type的取值为checkbox或radio的时候生效
									
								'post_url'=> 'getParentIdLookupPostUrl',
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
											
										'video_sort_type'=>array(
												'label'=>'分类类别',
												'width'=>'80'
										),
											
										'children_count'=>array(
												'label'=>'子分类数量',
												'width'=>'100'
										)
											
								),//template_display_columns end
									
				
								'additional_columns' => array(
										//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
										//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
										'video_sort_type'=> 'getSortType',
				
										'children_count'=> 'getChildrenCount',
								),
						),
				
				),
				
		),
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
