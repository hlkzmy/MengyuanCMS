<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Cms\Component\Article\ContentModel;

return array (
		
		'factories' => array (
		
				//加载转化率组的数据表
				'Cms\Component\Article\ContentModel'=>function($serviceManager){
				
					$dbAdapter = $serviceManager->get ( 'Zend\Db\Adapter\Adapter' );
					
					return new ContentModel ( $dbAdapter );
				  
				},
				
		)//factories end
		
);//array end

