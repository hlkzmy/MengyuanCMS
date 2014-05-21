<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Cms\Component\Article\BreadCrumb\Title\Model\Article;
use Cms\Component\Article\BreadCrumb\Title\Model\ArticleSort;


return array (
		
		'factories' => array (
		
				'Cms\Component\Article\BreadCrumb\Title\Model\ArticleSort'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
						
					return new ArticleSort ( $dbAdapter );
				
				},
				
				'Cms\Component\Article\BreadCrumb\Title\Model\Article'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
				
					return new Article ( $dbAdapter );
				
				},
				
		),//factories end
		
		
		
		
);//array end

