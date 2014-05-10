<?php

//以下为注册表单对象
use Article\Form\ArticleForm;
use Article\Form\ArticleSortForm;



return array(
		
		'factories' => array(
		
				//以下为注册表单对象
				'Resource\Article\ArticleForm' =>  function($sm) {
					return new ArticleForm();
				},
				'Resource\Article\ArticleSortForm' =>  function($sm) {
					return new ArticleSortForm();
				},
				
		),
    
        
    
);
