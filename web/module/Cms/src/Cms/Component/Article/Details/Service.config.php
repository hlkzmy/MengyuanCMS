<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Cms\Component\Article\Column\Model\Article;
use Cms\Component\Article\Column\Model\ArticleCategory as ArticleCategory;
use Cms\Component\Article\Column\Model\ArticleContent as ArticleContent;

return array (
		
		'factories' => array (
		
				//加载转化率组的数据表
				'Cms\Component\Article\Details\Model\Article'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
					
					return new Article ( $dbAdapter );
				  
				},
				
				'Cms\Component\Article\Details\Model\ArticleCategory'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
						
					return new ArticleCategory ( $dbAdapter );
				
				},
				
				'Cms\Component\Article\Details\Model\ArticleContent'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
						
					return new ArticleContent ( $dbAdapter );
				
				},
				
		),//factories end
		
		
		
		
);//array end

