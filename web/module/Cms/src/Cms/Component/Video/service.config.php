<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array (
		
		'factories' => array (
		
				//加载转化率租的表单
				'Event\Form\ConversionRateForm'=>function($serviceManager){
				
					return array('zhaomengyuan');
				},
				
		
		)//factories end
		
);//array end

