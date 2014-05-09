<?php

use News\Model\ArticleInfoModel;
use News\Model\ArticleContentModel;
use News\Model\ArticleSortModel;
use News\Model\RoleArticleSortModel;
use News\Model\UserModel;
use News\Model\UserRoleModel;
use News\Model\MenuModel;


return array(
		 
		'factories' => array(
					
				'News\Model\ArticleModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new ArticleModel($dbAdapter);
				},
				'News\Model\ArticleSortModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new ArticleSortModel($dbAdapter);
				},
				'News\Model\UserModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new UserModel($dbAdapter);
				},
				'News\Model\UserRoleModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new UserRoleModel($dbAdapter);
				},
				'News\Model\RoleArticleSortModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new RoleArticleSortModel($dbAdapter);
				},
				'News\Model\ArticleInfoModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new ArticleInfoModel($dbAdapter);
				},
				'News\Model\ArticleContentModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new ArticleContentModel($dbAdapter);
				},
				'News\Model\ArticleSortModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new ArticleSortModel($dbAdapter);
				},
				'News\Model\MenuModel' =>  function($sm) {
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					return new MenuModel($dbAdapter);
				},
		),
);