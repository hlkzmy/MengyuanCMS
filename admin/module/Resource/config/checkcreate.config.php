<?php

return array(
    'resource.video.checkcreate' => array(
        'file' => true,
        'preproccess' => array(
            //对所有需要预处理的数据进行处理		
            'postdata' => array(
                'generateSpeakerJsonData',
                'generateVideoFilterAreaData',
                'getAddUserId',
                'getVideoYear'
            ),
            //运行一些前置的函数，先进行一些与数据无关的检验		
            'check' => array(
            )
        ), //end of preproccess
        'filter' => array(
            'videoFilter' => array(
                'columns' => array(
                    'upload_flag' => '',
                    'name' => '',
                    'speaker' => '',
                    'description' => '',
                    'video_sort_id' => array(
                        'type' => 'map',
                        'from' => 'video_video_sort_id'
                    ),
                    'school_id' => '',
                    'user_id' => ''
                ),
            ),
            'videoFilterFilter' => array(
                'columns' => array(
                    'year' => '',
                    'country_id' => '',
                    'province_id' => '',
                    'city_id' => '',
                    'district_id' => '',
                    'school_id' => ''
                ),
            ),
            'videoPlayInfoFilter' => array(
                'year' => ''
            ),
            'videoLabelFilter' => array(
                'array_columns' => array(
                    'video_label_id' => ''
                ),
            ),
        ), //end of filter
        'model' => array(
            'videoModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'videoFilter',
                'columns' => array(
                    'name' => '',
                    'speaker' => '',
                    'description' => '',
                    'video_sort_id' => '',
                    'school_id' => '',
                    'user_id' => ''
                ),
                'additional_columns' => array(
                    'thumb' => array(
                        'type' => 'upload_info',
                        'map' => 'upload_flag_ThumbBasename'
                    ),
                    'pv' => array(
                        'type' => 'default',
                        'value' => '1'
                    ),
                    'media_id' => array(
                        'type' => 'default',
                        'value' => '0'
                    ),
                    'score' => array(
                        'type' => 'default',
                        'value' => '6'
                    ),
                    'chapter_count' => array(
                        'type' => 'default',
                        'value' => '1'
                    ),
                    'record_type' => array(
                        'type' => 'default',
                        'value' => 'd'
                    ),
                    'add_time' => array(
                        'type' => 'system',
                        'function' => 'date',
                        'parameter' => 'Y-m-d H:i:s'
                    ),
                    'download_status' => array(
                        'type' => 'default',
                        'value' => 'finished'
                    ),
                    'translate_status' => array(
                        'type' => 'default',
                        'value' => 'Y'
                    ),
                    'status' => array(
                        'type' => 'default',
                        'value' => 'Y'
                    )
                ),
            ),
            'videoPlayinfoModel' => array(
                'type' => 'salveModel',
                'filter_name' => 'videoPlayInfoFilter',
                'columns' => array(
                ),
                'additional_columns' => array(
                    'id' => array(
                        'type' => 'parameter',
                        'parameter' => 'lastInsertValue',
                    ),
                    'chapter_number' => array(
                        'type' => 'default',
                        'value' => '1'
                    ),
                    'filename' => array(
                        'type' => 'upload_info',
                        'map' => 'upload_flag_filename'
                    ),
                    'size' => array(
                        'type' => 'upload_info',
                        'map' => 'upload_flag_size'
                    ),
                    'length' => array(
                        'type' => 'upload_info',
                        'map' => 'upload_flag_length'
                    ),
                    'thumb' => array(
                        'type' => 'upload_info',
                        'map' => 'upload_flag_ThumbBasename'
                    )
                ),
            ),
            'videoFilterModel' => array(
                'type' => 'salveModel',
                'filter_name' => 'videoFilterFilter',
                'columns' => array(
                    'year' => '',
                    'country_id' => '',
                    'province_id' => '',
                    'city_id' => '',
                    'district_id' => '',
                    'school_id' => ''
                ),
                'additional_columns' => array(
                    'id' => array(
                        'type' => 'parameter',
                        'parameter' => 'lastInsertValue'
                    )
                ),
            ),
            'videoLabelModel' => array(
                'type' => 'slaveModel',
                'filter_name' => 'videoLabelFilter',
                'columns' => array(
                    //这里放的是普通的字段，不是重复字段，也不是主要字段。这些字段是会经过filter验证的
                    //不经过filter验证的字段意味着不从postdata里面拿，写在additional_columns里面
                    'video_label_id' => "",
                ),
                'array_columns' => array(
                    //这里放会重复的字段
                    'video_label_id' => '',
                ),
                'master_columns' => array(
                    //这里放置必须出现的主要字段，例如用户角色表的用户id
                    //这里这么写是为了跟edit的配置匹配和类似，方便以后自己写配置
                    'video_id' => array(
                        'type' => 'parameter',
                        'parameter' => 'lastInsertValue'
                    ),
                )
            )
        ), //end of model
        'rehabilitation' => array(
        //进行一些善后处理，对无限分类的部分进行伤口缝合
        )//end of rehabilitation
    ),
    'resource.videosort.checkcreate' => array(
        'preproccess' => array(
            //对所有需要预处理的数据进行处理
            'postdata' => array(
            ),
            //运行一些前置的函数，先进行一些与数据无关的检验
            'check' => array(
            )
        ), //end of preproccess
        'filter' => array(
            'videoSortFilter' => array(
                'columns' => array(
                    'name' => '',
                    'description' => '',
                    'parent_id' => array(
                        'type' => 'map',
                        'from' => 'videosort_parent_id',
                    ),
                ),
            ),
        ), //end of filter
        'model' => array(
            'videoSortModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'videoSortFilter',
                'columns' => array(
                    'name' => '',
                    'description' => '',
                    'parent_id' => '',
                ),
                'additional_columns' => array(
                    'sequence' => array(
                        'type' => 'default',
                        'value' => '0'
                    ),
                    'status' => array(
                        'type' => 'default',
                        'value' => 'Y',
                    ),
                    'constant' => array(
                        'type' => 'default',
                        'value' => 'N',
                    )
                ),
            ),
        ), //end of model
        'rehabilitation' => array(
            //进行一些善后处理，对无限分类的部分进行伤口缝合

            array(
                'type' => 'sort',
                'model' => 'videoSortModel'
            )
        )//end of rehabilitation
    ),
    'resource.videolabel.checkcreate' => array(
        'preproccess' => array(
        ), //end of preproccess
        'filter' => array(
            'labelFilter' => array(
                'columns' => array(
                    'name' => '',
                    'description' => array(
                            "allowEmpty"=>true
                    ),
                ),
            ),
        ), //end of filter
        'model' => array(
            'labelModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'labelFilter',
                'columns' => array(
                    'name' => '',
                    'description' => '',
                ),
            ),
        ), //end of model
    ),
    'resource.courseware.checkcreate' => array(
        'file' => true,
        'filter' => array(
            'courswareFilter' => array(
                'columns' => array(
                    'name' => '',
                    'courseware_sort_id' => array(
                        'type' => 'map',
                        'from' => 'coursewaresort_courseware_sort_id'
                    ),
                    'video_id' => array(
                        'type' => 'map',
                        'from' => 'video_video_id'
                    ),
                    'description' => '',
                ),
            ),
        ), //end of filter
        'model' => array(
            'coursewareModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'courswareFilter',
                'columns' => array(
                    'name' => '',
                    'courseware_sort_id' => '',
                    'video_id' => '',
                    'description' => '',
                ),
                'additional_columns' => array(
                    'add_user_id' => array(
                        'type' => 'function',
                        'function' => 'getLoginUserId'
                    ),
                    'hash' => array(
                        'type' => 'upload_info',
                        'map' => 'courseware_hash'
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
        ), //end of model
        'rehabilitation' => array(
        //进行一些善后处理，对无限分类的部分进行伤口缝合
        )//end of rehabilitation
    ),
    'resource.coursewaresort.checkcreate' => array(
        'filter' => array(
            'courswareSortFilter' => array(
                'columns' => array(
                    'name' => '',
                    'parent_id' => array(
                        'type' => 'map',
                        'from' => 'coursewaresort_parent_id'
                    ),
                    'description' => '',
                ),
            ),
        ), //end of filter
        'model' => array(
            'coursewareSortModel' => array(
                'type' => 'masterModel',
                'filter_name' => 'courswareSortFilter',
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
                'model' => 'coursewareSortModel'
            )
        )//end of rehabilitation
    ),
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
