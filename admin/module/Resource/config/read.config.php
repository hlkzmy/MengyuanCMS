<?php

return array(
    
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
   
);
