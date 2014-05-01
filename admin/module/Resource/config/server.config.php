<?php

//以下为注册过滤对象
use Base\Filter\VideoFilter;
use Base\Filter\VideoSortFilter;
use Base\Filter\CoursewareFilter;
use Base\Filter\CourswareSortFilter;
use Base\Filter\VideoFilterFilter;
use Base\Filter\VideoPlayInfoFilter;

use Base\Filter\ArticleFilter;
use Base\Filter\ArticleContentFilter;
use Base\Filter\ArticleSortFilter;



//以下为注册表单对象
use Video\Form\VideoForm;
use Video\Form\VideoSortForm;
use Video\Form\VideoLabelForm;
use Article\Form\ArticleForm;
use Article\Form\ArticleSortForm;
use Courseware\Form\CoursewareForm;
use Courseware\Form\CoursewareSortForm;


return array(
		
		'factories' => array(
		
				//以下为注册表单对象
				'Resource\Video\VideoForm' =>  function($sm) {
					return new VideoForm();
				},
				
				'Resource\Video\VideoSortForm' =>  function($sm) {
					return new VideoSortForm();
				},
				
				'Resource\Video\VideoLabelForm' =>  function($sm) {
					return new VideoLabelForm();
				},
				
				'Resource\Article\ArticleForm' =>  function($sm) {
				
					
					return new ArticleForm();
				},
				'Resource\Article\ArticleSortForm' =>  function($sm) {
					return new ArticleSortForm();
				},
				
				'Resource\Courseware\CoursewareForm' =>  function($sm) {
					return new CoursewareForm();
				},
				
				'Resource\Courseware\CoursewareSortForm' =>  function($sm) {
					return new CoursewareSortForm();
				}
				
					
		),
    
        
    
);
