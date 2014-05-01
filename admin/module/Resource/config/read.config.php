<?php

return array(
    'resource.video.read' => array(
        'type' => 'filter',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据	
        'order' => array('id' => 'desc'),
        'master_model' => 'videoModel',
        //进行查询所对应的主表
        'layout_height' => 140,
        //格式保留的高度
        'select_control_type' => 'checkbox',
        //列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项
        //如果不写这个选项的话，就认为默认是不出现选择控件
        //现阶段这个选项只在过滤列表中起作用，在无限分类列表中不起作用
        'filter_constant_condition' => array(
            'download_status' => array('method' => 'eq', 'value' => 'finished'),
            'status' => array('method' => 'neq', 'value' => 'D')
        ),
        'columns' => array(
            //在列表中需要显示的字段		
            'id' => '',
            'name' => '',
            'chapter_count' => '',
            'pv' => '',
            'score' => '',
            'user_id' => array(
                'type' => 'query',
                'model' => 'userModel',
                'query_field' => 'id',
                'result_field' => 'realname'
            ),
            'video_sort_id' => array(
                'type' => 'query',
                'model' => 'videoSortModel',
                'query_field' => 'id',
                'result_field' => 'name'
            ),
            'add_time' => '',
        	'upload_status' => '',
            'status' => ''
        ),
        'additional_columns' => array(
            'status_string' => 'getStatusString',
        	'upload_status_string'=>'getUploadStatusString'	
        		
        		
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '视频名称',
            ),
            'user_id_string' => array(
                'label' => '视频添加人',
                'width' => 160
            ),
            'video_sort_id_string' => array(
                'label' => '视频分类',
                'width' => '200'
            ),
            'chapter_count' => array(
                'label' => '章节数',
                'width' => '80'
            ),
            'score' => array(
                'label' => '得分',
                'width' => '80'
            ),
            'pv' => array(
                'label' => '浏览量',
                'width' => '80'
            ),
            'add_time' => array(
                'label' => '添加时间',
                'width' => '160'
            ),
        	'upload_status_string' => array(
        			'label' => '上传状态',
        			'width' => '100'
        	),
            'status_string' => array(
                'label' => '视频状态',
                'width' => '100'
            )
        ), //template_display_columns end
        'pager_form' => array(
            'row_element_count' => 3,
            'columns' => array(
                'id' => array(
                    'form_control' => 'text',
                    'method' => 'eq',
                ),
                'name' => array(
                    'form_control' => 'text',
                    'method' => 'like',
                ),
                'user_id' => array(
                    'label' => '视频添加人',
                    'form_control' => 'text',
                    'method' => 'like'
                ),
                'pv' => array(
                    'form_control' => 'text',
                    'method' => 'eq'
                ),
                'chapter_count' => array(
                    'form_control' => 'text',
                    'method' => 'eq',
                ),
            ), //columns end
        ), //pager_form end
        'pagination' => array(
            'page_row_count' => 30,
            'select_value_options' => array(
                '30' => 30,
                '60' => 60,
                '120' => 120,
                '240' => 240,
                '300' => 300,
            )
        ), //pagination end
        'operation_list' => array(
            array(
                'title' => '添加视频',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'video', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除视频',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'video', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑视频',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'video', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
            array(
                'title' => '批量删除',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'video', 'action' => 'multiDelete'),
                'rel' => 'ids[]',
                'target' => 'selectedTodo'
            ),
            array(
                'title' => '批量生成缩略图',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'video', 'action' => 'thumb'),
                'rel' => 'ids[]',
                'target' => 'selectedTodo'
            ),
            array(
                'title' => '批量审核',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'video', 'action' => 'videoCheck'),
                'rel' => 'ids[]',
                'target' => 'selectedTodo'
            ),
        	array(
        				'title' => '批量上传视频',
        				'route' => 'resource',
        				'route_parameter' => array('controller' => 'video', 'action' => 'videoUpload'),
        				'rel' => 'ids[]',
        				'target' => 'selectedTodo'
        	),
        ),
    ), //resource.video.read end
    'resource.videosort.read' => array(
        'type' => 'unlimited',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
        'root_id' => 1,
        'level' => 2,
        'master_model' => 'videoSortModel',
        'select_control_type' => 'none',
        //列表中每一行前面的选择框是多选框checkbox，还是单选框radio,还是什么都没有none，现阶段只允许有这三个选项，
        //如果不是这三个选项就报错
        'select_type' => 'none',
        'post_url' => 'getVideoSortListPostUrl',
        //得到由video_sort_id触发的查找带回的请求的网址，且只在type的取值为unlimited的时候生效
        'columns' => array(
            //在列表中需要显示的字段
            'id' => '',
            'name' => '',
            'left_number' => '',
            'right_number' => '',
            'parent_id' => '',
            'level' => '',
            'status' => '',
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '视频名称',
            ),
            'level' => array(
                'label' => '分类级别',
                'width' => '80'
            ),
            'video_sort_type' => array(
                'label' => '分类类别',
                'width' => '120'
            ),
            'children_count' => array(
                'label' => '子分类数量',
                'width' => '80'
            ),
            'status_string' => array(
                'label' => '分类状态',
                'width' => '80'
            ),
        ), //template_display_columns end	
        'additional_columns' => array(
            //在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
            //前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录	

            'video_sort_type' => 'getSortType',
            'children_count' => 'getChildrenCount',
            'status_string' => 'getStatusString'
        ),
        'operation_list' => array(
            array(
                'title' => '添加视频分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'videoSort', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除视频分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'videoSort', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑视频分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'videoSort', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
        ), //operation_list end
    ), //resource.video.read end
    'resource.videolabel.read' => array(
        'type' => 'filter',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
        'master_model' => 'labelModel',
        //进行查询所对应的主表
        'layout_height' => 140,
        'columns' => array(
            //在列表中需要显示的字段
            'id' => '',
            'name' => '',
            'status' => ''
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '标签名称',
            ),
            'status' => array(
                'label' => '标签状态',
            ),
        ), //template_display_columns end
        'pagination' => array(
            'page_row_count' => 30
        ),
        'pager_form' => array(
            'row_element_count' => 3,
            'columns' => array(
                'id' => array(
                    'form_control' => 'text',
                    'method' => 'eq',
                ),
                'name' => array(
                    'form_control' => 'text',
                    'method' => 'like',
                ),
            ), //columns end
        ), //pager_form end
        'operation_list' => array(
            array(
                'title' => '添加标签',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'videolabel', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除标签',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'videolabel', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑标签',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'videolabel', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
        ), //operation_list end
    ), //resource.video.read end	
    'resource.download.read' => array(
        'type' => 'filter',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
        'master_model' => 'videoModel',
        //进行查询所对应的主表
        'filter_constant_condition' => array(
            'download_status' => array('method' => 'notin', 'value' => array('finished', 'wait')),
        ),
        'use_assigned_template' => 'video/download/list',
        'select_control_type' => 'checkbox',
        'columns' => array(
            //在列表中需要显示的字段
            'id' => '',
            'name' => '',
            'chapter_count' => '',
            'school_id' => array(
                'type' => 'query',
                'model' => 'schoolModel',
                'query_field' => 'id',
                'result_field' => 'name'
            ),
            'download_status' => '',
            'add_time' => '',
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '视频名称',
                'width' => 120
            ),
            'school_id_string' => array(
                'label' => '学校名称',
                'width' => 160
            ),
            'download_process' => array(
                'label' => '下载进度',
                'class' => 'progress'
            ),
            'download_status_string' => array(
                'label' => '下载状态',
                'width' => 100,
            ),
            'add_time' => array(
                'label' => '上传时间',
                'width' => '120'
            )
        ), //template_display_columns end
        'additional_columns' => array(
            //在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
            //前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
            'download_process' => 'getDownloadProcess',
            'download_status_string' => 'getDownloadStatusString'
        ),
        'pager_form' => array(
            'row_element_count' => 3,
            'columns' => array(
                'name' => array(
                    'form_control' => 'text',
                    'method' => 'like',
                ),
                'school_id' => array(
                    'label' => '学校名称',
                    'form_control' => 'text',
                    'method' => 'like',
                ),
            ), //columns end
        ), //pager_form end
        'pagination' => array(
            'page_row_count' => 30,
            'select_value_options' => array(
                '30' => 30,
                '60' => 60,
                '120' => 120,
                '240' => 240,
                '300' => 300,
            )
        ), //pagination end
        'operation_list' => array(
            array(
                'title' => '开始下载',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'download', 'action' => 'start'),
                'rel' => 'ids[]',
                'target' => 'selectedTodo'
            ),
            array(
                'title' => '暂停下载',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'download', 'action' => 'stop'),
                'rel' => 'ids[]',
                'target' => 'selectedTodo'
            ),
            array(
                'title' => '取消下载',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'download', 'action' => 'cancel'),
                'rel' => 'ids[]',
                'target' => 'selectedTodo'
            ),
        ),
        'layout_height' => 115
    ), //resource.download.read end
    'resource.article.read' => array(
        'type' => 'filter',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
        'master_model' => 'articleModel',
        //进行查询所对应的主表
        'layout_height' => 140,
        'columns' => array(
            //在列表中需要显示的字段
            'id' => '',
            'title' => '',
            'hits' => '',
            'article_sort_id' => array(
                'type' => 'query',
                'model' => 'articleSortModel',
                'query_field' => 'id',
                'result_field' => 'name'
            ),
            'user_id' => array(
                'type' => 'query',
                'model' => 'userModel',
                'query_field' => 'id',
                'result_field' => 'realname'
            ),
            'add_time' => '',
            'status' => ''
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'title' => array(
                'label' => '文章名称',
            ),
            'article_sort_id_string' => array(
                'label' => '文章分类',
                'width' => '200'
            ),
            'user_id_string' => array(
                'label' => '作者',
                'width' => '120'
            ),
            'hits' => array(
                'label' => '点击数',
                'width' => '80'
            ),
            'add_time' => array(
                'label' => '添加时间',
                'width' => '160'
            ),
        ), //template_display_columns end
        'pagination' => array(
            'page_row_count' => 30
        ),
        'pager_form' => array(
            'row_element_count' => 3,
            'columns' => array(
                'id' => array(
                    'form_control' => 'text',
                    'method' => 'eq',
                ),
                'title' => array(
                    'form_control' => 'text',
                    'method' => 'like',
                ),
                'user_id' => array(
                    'label' => '作者',
                    'form_control' => 'text',
                    'method' => 'like'
                ),
                'hits' => array(
                    'form_control' => 'text',
                    'method' => 'eq'
                ),
                'keyword' => array(
                    'label' => '文章关键字',
                    'form_control' => 'text',
                    'method' => 'like'
                ),
            ), //columns end
        ), //pager_form end
        'operation_list' => array(
            array(
                'title' => '添加文章',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'article', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除文章',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'article', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑文章',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'article', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
        ), //operation_list end
    ), //resource.video.read end
    'resource.articlesort.read' => array(
        'type' => 'unlimited',
        'root_id' => 1,
        'level' => 4,
        'master_model' => 'articleSortModel',
        'select_control_type' => 'none',
        'select_type' => 'both',
        'post_url' => 'getArticleSortListPostUrl',
        'columns' => array(
            //在列表中需要显示的字段

            'id' => '',
            'name' => '',
            'left_number' => '',
            'right_number' => '',
            'parent_id' => '',
            'level' => '',
            'status' => '',
        ),
        'additional_columns' => array(
            //在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
            //前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录

            'article_sort_type' => 'getSortType',
            'children_count' => 'getChildrenCount',
            'status_string' => 'getStatusString'
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '分类名称',
            ),
            'level' => array(
                'label' => '分类级别',
                'width' => '80'
            ),
            'article_sort_type' => array(
                'label' => '分类类别',
                'width' => '120'
            ),
            'children_count' => array(
                'label' => '子分类数量',
                'width' => '80'
            ),
            'status_string' => array(
                'label' => '分类状态',
                'width' => '80'
            ),
        ), //template_display_columns end
        'operation_list' => array(
            array(
                'title' => '添加文章分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'articleSort', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除文章分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'articleSort', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑文章分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'articleSort', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
        ), //operation_list end
    ), //resource.video.read end
    'resource.courseware.read' => array(
        'type' => 'filter',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
        'master_model' => 'coursewareModel',
        //进行查询所对应的主表
        'order' => array('add_time' => 'desc'),
        'layout_height' => 140,
        'columns' => array(
            //在列表中需要显示的字段
            'id' => '',
            'name' => '',
            'courseware_sort_id' => array(
                'type' => 'query',
                'model' => 'coursewareSortModel',
                'query_field' => 'id',
                'result_field' => 'name'
            ),
            'add_user_id' => array(
                'type' => 'query',
                'model' => 'userModel',
                'query_field' => 'id',
                'result_field' => 'realname'
            ),
            'add_time' => '',
            'status' => ''
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '课件名称',
            ),
            'courseware_sort_id_string' => array(
                'label' => '所属分类',
                'width' => '200'
            ),
            'add_user_id_string' => array(
                'label' => '作者',
                'width' => '80'
            ),
            'add_time' => array(
                'label' => '添加时间',
                'width' => '160'
            )
        ), //template_display_columns end
        'pager_form' => array(
            'row_element_count' => 3,
            'columns' => array(
                'id' => array(
                    'form_control' => 'text',
                    'method' => 'eq',
                ),
                'name' => array(
                    'form_control' => 'text',
                    'method' => 'like',
                ),
                'add_user_id' => array(
                    'label' => '作者',
                    'form_control' => 'text',
                    'method' => 'like'
                )
            ), //columns end
        ), //pager_form end
        'pagination' => array(
            'page_row_count' => 30
        ),
        'operation_list' => array(
            array(
                'title' => '添加课件',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'courseware', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除课件',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'courseware', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑课件',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'courseware', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
        ), //operation_list end
    ), //resource.video.read end
    'resource.coursewaresort.read' => array(
        'type' => 'unlimited',
        //列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
        'root_id' => 1,
        'level' => 3,
        'master_model' => 'coursewareSortModel',
        'select_control_type' => 'none',
        'select_type' => 'both',
        'post_url' => 'getCoursewareSortListPostUrl',
        'columns' => array(
            //在列表中需要显示的字段

            'id' => '',
            'name' => '',
            'left_number' => '',
            'right_number' => '',
            'parent_id' => '',
            'level' => '',
            'status' => '',
        ),
        'additional_columns' => array(
            //在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
            //前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录

            'courseware_sort_type' => 'getSortType',
            'children_count' => 'getChildrenCount',
            'status_string' => 'getStatusString'
        ),
        'template_display_columns' => array(
            'id' => array(
                'label' => '编号',
                'width' => '60'
            ),
            'name' => array(
                'label' => '分类名称',
            ),
            'level' => array(
                'label' => '分类级别',
                'width' => '80'
            ),
            'courseware_sort_type' => array(
                'label' => '分类类别',
                'width' => '120'
            ),
            'children_count' => array(
                'label' => '子分类数量',
                'width' => '80'
            ),
            'status_string' => array(
                'label' => '分类状态',
                'width' => '80'
            ),
        ), //template_display_columns end
        'operation_list' => array(
            array(
                'title' => '添加课件分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'coursewareSort', 'action' => 'create'),
                'target' => 'navTab'
            ),
            array(
                'title' => '删除课件分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'coursewareSort', 'action' => 'delete'),
                'param' => 'id',
                'target' => 'ajaxTodo'
            ),
            array(
                'title' => '编辑课件分类',
                'route' => 'resource',
                'route_parameter' => array('controller' => 'coursewareSort', 'action' => 'update'),
                'param' => 'id',
                'target' => 'navTab'
            ),
        ), //operation_list end
    ), //resource.video.read end
		'resource.videocomment.read' => array(
				
				'order'=>array('add_time'=>'desc'),
		
				'type'	  => 'filter',
				//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
		
				'master_model'=>'videoCommentModel',
				//进行查询所对应的主表
				
				'select_control_type' => 'checkbox',
				'filter_constant_condition'=>array(
		
						'status'=>array('method'=>'neq','value'=>'N'),
				),
					
				'layout_height'=>140,
		
				'columns' => array(
						//在列表中需要显示的字段
						'id'=>'',
							
						'video_id'=>array(
								'type' =>'query',
								'model'=>'videoModel',
								'query_field' =>'id',
								'result_field'=>'name'
						),
							
						'user_id'=>array(
								'type' =>'query',
								'model'=>'userModel',
								'query_field' =>'id',
								'result_field'=>'realname'
						),
		
						'content'=>'',
		
						'add_time'=>'',
							
						'status'=>''
		
				),
		
				'additional_columns' => array(
						//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
						//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录
							
						'status_string'	      => 'getStatusString'
		
				),
					
				'template_display_columns' => array(
							
						'id'=>array(
								'label'=>'编号',
								'width'=>'30'
						),
						'video_id_string'=>array(
								'label'=>'所属视频',
								'width'=>'120'
						),
						'user_id_string'=>array(
								'label'=>'发表人',
								'width'=>'100'
						),
						'content'=>array(
								'label'=>'评论内容',
						),
						'add_time'=>array(
								'label'=>'添加时间',
								'width'=>'125'
						),
						'status_string'=>array(
								'label'=>'状态',
								'width'=>'60'
						)
		
				),//template_display_columns end
					
				'pager_form' =>array(
		
						'row_element_count'=>3,
		
						'columns' => array(
								'id'=>array(
										'form_control'=>'text',
										'method'=>'eq',
								),
								
								'video_id'=>array(
										'label'=>'所属视频',
										'form_control'=>'text',
										'method'=>'like',
								),
								
								'user_id'=>array(
										'label'=>'发表人',
										'form_control'=>'text',
										'method'=>'like',
								),
								'content'=>array(
										'label'=>'评论内容',
										'form_control'=>'text',
										'method'=>'like',
								)
									
						),//columns end
		
				),//pager_form end
		
				'pagination' =>array(
		
						'page_row_count'=>30
		
		
				),
					
				'operation_list'=>array(
		
						array(
								'title'=>'批量审核',
								'route'=>'resource',
								'route_parameter'=>array('controller'=>'videocomment','action'=>'check'),
								'rel' => 'ids[]',
								'target'=>'selectedTodo'
						),
						array(
								'title'=>'批量删除',
								'route'=>'resource',
								'route_parameter'=>array('controller'=>'videocomment','action'=>'delete'),
								'rel' => 'ids[]',
								'target'=>'selectedTodo'
						),
		
				),//operation_list end
		
		
		),//resource.video.read end
		
		
		'resource.evaluatecomment.read' => array(
		
				'type'	  => 'filter',
				//列表的类型，一种是筛选类型的数据,一种是不需要进行筛选的数据
		
				'master_model'=>'evaluationCommentModel',
				//进行查询所对应的主表
		
				'select_control_type' => 'checkbox',
					
				'layout_height'=>113,
		
				'columns' => array(
						//在列表中需要显示的字段
						'id'=>array(
								'type' =>'query',
								'model'=>'evaluationModel',
								'query_field' =>'id',
								'result_field'=>'name'
						),
							
						'user_id'=>array(
								'type' =>'query',
								'model'=>'userModel',
								'query_field' =>'id',
								'result_field'=>'realname'
						),
		
						'comment'=>'',
		
				),
		
				'additional_columns' => array(
						//在列表中也需要显示这些字段，但是这些字段并不存在与数据表中，是由其他的字段计算或转换而来
						//前面是字段名称，后面是计算或转换的方法，方法的参数都是每一行的记录

						
		
				),
					
				'template_display_columns' => array(
							
						'id'=>array(
								'label'=>'编号',
								'width'=>'30'
						),
						'id_string'=>array(
								'label'=>'所属视频',
								'width'=>'200'
						),
						'user_id_string'=>array(
								'label'=>'发表人',
								'width'=>'100'
						),
						'comment'=>array(
								'label'=>'评论内容',
						),
		
				),//template_display_columns end
					
				'pager_form' =>array(
		
						'row_element_count'=>3,
		
						'columns' => array(
								'id'=>array(
										'label'=>'所属教学评价名',
										'form_control'=>'text',
										'method'=>'like',
								),
								
								'user_id'=>array(
										'label'=>'发表人',
										'form_control'=>'text',
										'method'=>'like',
								),
								
								'comment'=>array(
										'label'=>'关键字',
										'form_control'=>'text',
										'method'=>'like',
								),								
								
								
									
									
						),//columns end
		
				),//pager_form end
		
				'pagination' =>array(
		
						'page_row_count'=>30
		
		
				),
					
				'operation_list'=>array(
		
						array(
								'title'=>'批量删除',
								'route'=>'resource',
								'route_parameter'=>array('controller'=>'evaluatecomment','action'=>'delete'),
								'rel' => 'ids[]',
								'target'=>'selectedTodo'
						),
		
				),//operation_list end
		
		
		),//resource.video.read end
);
