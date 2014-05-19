<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Web\Model\ArticleModel;
use Web\Model\ArticleContentModel;
use Web\Model\ArticleSortModel;

return array (
		
		'factories' => array (
		
				//加载文章内容相关的数据表
				'Web\Model\ArticleModel'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
						
					return new ArticleModel ( $dbAdapter );
				},
				
				'Web\Model\ArticleSortModel'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
				
					return new ArticleSortModel ( $dbAdapter );
				},
				
				'Web\Model\ArticleContentModel'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
				
					return new ArticleContentModel ( $dbAdapter );
				},
				
		)//factories end
		
		
		
		
		
);//array end

