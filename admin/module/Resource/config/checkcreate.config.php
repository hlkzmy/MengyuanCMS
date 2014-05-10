<?php

return array(
    
    'resource.article.checkcreate' => array(
        'filter' => array(
            'articleFilter' => array(
                'columns' => array(
                    'title' => '',
                    'sub_title' => '',
                    'article_sort_id' => array(
                        'type' => 'map',
                        'from' => 'articlesort_article_sort_id'
                    ),
                    'keyword' => '',
                    'content' => '',
                ),
            ),
            'articleContentFilter' => array(
                'columns' => array(
                    'content' => '',
                ),
            ),
        ), //end of filter
        'model' => array(
            'articleModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'articleFilter',
                'columns' => array(
                    'title' => '',
                    'sub_title' => '',
                    'article_sort_id' => '',
                    'keyword' => '',
                    'content' => '',
                ),
                'additional_columns' => array(
                    'user_id' => array(
                        'function' => 'getLoginUserId',
                        'type' => 'function'
                    ),
                    'add_time' => array(
                        'type' => 'system',
                        'function' => 'date',
                        'parameter' => 'Y-m-d H:i:s'
                    ),
                    'update_time' => array(
                        'type' => 'system',
                        'function' => 'date',
                        'parameter' => 'Y-m-d H:i:s'
                    ),
                    'status' => array(
                        'type' => 'default',
                        'value' => 'Y'
                    )
                ),
            ),
            'articleContentModel' => array(
                'type' => 'slaveModle',
                'filter_name' => 'articleContentFilter',
                'columns' => array(
                    'content' => '',
                ),
                'additional_columns' => array(
                    'id' => array(
                        'type' => 'parameter',
                        'parameter' => 'lastInsertValue'
                    )
                )
            )
        ), //end of model
    ), //end of article
    'resource.articlesort.checkcreate' => array(
        'filter' => array(
            'articleSortFilter' => array(
                'columns' => array(
                    'name' => '',
                    'parent_id' => array(
                        'type' => 'map',
                        'from' => 'articlesort_parent_id'
                    ),
                    'description' => '',
                ),
            ),
        ), //end of filter
        'model' => array(
            'articleSortModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'articleSortFilter',
                'columns' => array(
                    'name' => '',
                    'parent_id' => '',
                    'description' => '',
                ),
                'additional_columns' => array(
                    'status' => array(
                        'type' => 'default',
                        'value' => 'Y'
                    )
                ),
            ),
        ), //end of model
        'rehabilitation' => array(
            //进行一些善后处理，对无限分类的部分进行伤口缝合

            array(
                'type' => 'sort',
                'model' => 'articleSortModel'
            )
        )//end of rehabilitation
    ), //end of articlesort
);
