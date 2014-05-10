<?php



//------------------------------网站相关的数据表-------------------------------//
use Etah\Mvc\Model\Website\ContainerModel;
use Etah\Mvc\Model\Website\ElementModel;
use Etah\Mvc\Model\Website\NavigationModel;
use Etah\Mvc\Model\Website\PageModel;
//------------------------------网站相关的过滤器-------------------------------//
use Etah\Mvc\Filter\Website\ContainerFilter;
use Etah\Mvc\Filter\Website\ElementFilter;
use Etah\Mvc\Filter\Website\NavigationFilter;
use Etah\Mvc\Filter\Website\PageFilter;


//------------------------------系统相关的数据表-------------------------------//
use Etah\Mvc\Model\System\MenuModel;
use Etah\Mvc\Model\System\AreaModel;
use Etah\Mvc\Model\System\RoleModel;
use Etah\Mvc\Model\System\UserRoleModel;
use Etah\Mvc\Model\System\LogModel;
//------------------------------系统相关的过滤器-------------------------------//
use Etah\Mvc\Filter\System\RoleFilter;
use Etah\Mvc\Filter\System\UserRoleFilter;
use Etah\Mvc\Filter\System\AreaFilter;

//----------------------------信息相关的数据表-------------------------------//
use Etah\Mvc\Model\Information\SchoolModel;
use Etah\Mvc\Model\Information\SchoolSortModel;
use Etah\Mvc\Model\Information\SchoolRecordServerModel;
use Etah\Mvc\Model\Information\ClassroomModel;
use Etah\Mvc\Model\Information\ClassroomStreamModel;
use Etah\Mvc\Model\Information\UserModel;
use Etah\Mvc\Model\Information\SubjectModel;
use Etah\Mvc\Model\Information\WorkTypeModel;
use Etah\Mvc\Model\Information\UserCertificateModel;
use Etah\Mvc\Model\Information\GradeModel;


//----------------------------信息相关的过滤器-------------------------------//
use Etah\Mvc\Filter\Information\ClassroomFilter;
use Etah\Mvc\Filter\Information\UserFilter;
use Etah\Mvc\Filter\Information\SchoolFilter;
use Etah\Mvc\Filter\Information\CertificateFilter;

//----------------------------资源文件相关的数据表-------------------------------//
use Etah\Mvc\Model\Resource\ArticleModel;
use Etah\Mvc\Model\Resource\ArticleContentModel;
use Etah\Mvc\Model\Resource\ArticleSortModel;
use Etah\Mvc\Model\Resource\CoursewareModel;
use Etah\Mvc\Model\Resource\CoursewareSortModel;
use Etah\Mvc\Model\Resource\VideoModel;
use Etah\Mvc\Model\Resource\VideoFilterModel;
use Etah\Mvc\Model\Resource\VideoPlayinfoModel;
use Etah\Mvc\Model\Resource\VideoSortModel;
use Etah\Mvc\Model\Resource\VideoLabelModel;
use Etah\Mvc\Model\Resource\LabelModel;
use Etah\Mvc\Model\Resource\VideoCommentModel;

//----------------------------资源文件相关的过滤器-------------------------------//
use Etah\Mvc\Filter\Resource\ArticleContentFilter;
use Etah\Mvc\Filter\Resource\ArticleFilter;
use Etah\Mvc\Filter\Resource\ArticleSortFilter;
use Etah\Mvc\Filter\Resource\CoursewareFilter;
use Etah\Mvc\Filter\Resource\CoursewareSortFilter;
use Etah\Mvc\Filter\Resource\VideoFilter;
use Etah\Mvc\Filter\Resource\VideoSortFilter;
use Etah\Mvc\Filter\Resource\VideoFilterFilter;
use Etah\Mvc\Filter\Resource\VideoPlayinfoFilter;
use Etah\Mvc\Filter\Resource\LabelFilter;
use Etah\Mvc\Filter\Resource\VideoLabelFilter;

//----------------------------教学评价相关的数据表-------------------------------//
use Etah\Mvc\Model\Evaluate\EvaluationModel;
use Etah\Mvc\Model\Evaluate\EvaluationEvaluatorModel;
use Etah\Mvc\Model\Evaluate\EvaluationSortModel;
use Etah\Mvc\Model\Evaluate\GaugeModel;
use Etah\Mvc\Model\Evaluate\GaugeSortModel;
use Etah\Mvc\Model\Evaluate\EvaluationCommentModel;

//----------------------------教学评价相关的过滤器-------------------------------//

use Etah\Mvc\Filter\Evaluate\GaugeFilter;
use Etah\Mvc\Filter\Evaluate\GaugeSortFilter;
use Etah\Mvc\Filter\Evaluate\EvaluationEvaluatorFilter;
use Etah\Mvc\Filter\Evaluate\EvaluationFilter;
use Etah\Mvc\Filter\Evaluate\EvaluationSortFilter;

//----------------------------直播相关数据表-------------------------------------//

use Etah\Mvc\Model\Common\LiveClassroomModel;
use Etah\Mvc\Model\Common\InteractClassroomModel;


//---------------------------直播相关过滤器--------------------------------------//


use Etah\Mvc\Filter\common\LiveClassroomFilter;

use Etah\Mvc\Filter\common\InteractClassroomFilter;


//------------------------------权限插件相关的数据表-------------------------------//
use Etah\Mvc\Plugin\Permission\Model\AccessModel   as PermissionAccessModel;
use Etah\Mvc\Plugin\Permission\Model\UserRoleModel as PermissionUserRoleModel;
use Etah\Mvc\Plugin\Permission\Model\NodeModel as PermissionNodeModel;
use Etah\Mvc\Plugin\Permission\Model\MenuModel as PermissionMenuModel;

//------------------------------日志记录插件相关的数据表-------------------------------//
use Etah\Mvc\Plugin\Log\Model\NodeModel as LogsNodeModel;


return array(
		
		'factories' => array(
		
//------------------------------权限插件相关的数据表-------------------------------//
				
				'Base\Plugin\Permission\Model\AccessModel' => function ($sm) {
					$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
					return new PermissionAccessModel ( $dbAdapter );
				},
				'Base\Plugin\Permission\Model\NodeModel' => function ($sm) {
					$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
					return new PermissionNodeModel ( $dbAdapter );
				},
				'Base\Plugin\Permission\Model\UserRoleModel' => function ($sm) {
					$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
					return new PermissionUserRoleModel ( $dbAdapter );
				},
				'Base\Plugin\Permission\Model\MenuModel' => function ($sm) {
					$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
					return new PermissionMenuModel ( $dbAdapter );
				},
//------------------------------日志记录插件相关的数据表-------------------------------//			
				
				'Base\Plugin\Logs\Model\NodeModel' => function ($sm) {
					$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
					return new LogsNodeModel ( $dbAdapter );
				},
				
//-------------------------------系统相关的基础数据表-------------------------------//
				
				'Base\Model\MenuModel' => function ($sm) {
					$dbAdapter = $sm->get ( 'Zend\Db\Adapter\Adapter' );
					return new MenuModel ( $dbAdapter );
				},
				
				'Base\Model\ContainerModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new ContainerModel($dbAdapter);
				},
				
				'Base\Model\ElementModel' =>  function($sm) {
		
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		
					return new ElementModel($dbAdapter);
				},
				
				'Base\Model\UserModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new UserModel($dbAdapter);
				},
				
				'Base\Model\GradeModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new GradeModel($dbAdapter);
				},
				
				'Base\Model\PageModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new PageModel($dbAdapter);
				},
				
				'Base\Model\SchoolModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new SchoolModel($dbAdapter);
				},
				
				'Base\Model\SchoolSortModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						
					return new SchoolSortModel($dbAdapter);
				},
				
				'Base\Model\SchoolRecordServerModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new SchoolRecordServerModel($dbAdapter);
				},
				'Base\Model\ClassroomModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new ClassroomModel($dbAdapter);
				},
				
				'Base\Model\ClassroomStreamModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new ClassroomStreamModel($dbAdapter);
				},
				
				'Base\Model\AreaModel' =>function($sm){
					
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new AreaModel($dbAdapter);
					
				},
				
				'Base\Model\NavigationModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new NavigationModel($dbAdapter);
				},
				
				'Base\Model\ArticleModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new ArticleModel($dbAdapter);
				},
				
				'Base\Model\ArticleContentModel' =>  function($sm) {
		
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		
					return new ArticleContentModel($dbAdapter);
				},
				
				'Base\Model\ArticleSortModel' =>  function($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new ArticleSortModel($dbAdapter);
				},
				
				'Base\Model\CoursewareModel'  =>  function ($sm) {

					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new CoursewareModel($dbAdapter);
				},
				
				'Base\Model\CoursewareSortModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new CoursewareSortModel($dbAdapter);
				},
				
				'Base\Model\VideoModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						
					return new VideoModel($dbAdapter);
				},
				
				'Base\Model\VideoSortModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						
					return new VideoSortModel($dbAdapter);
				},
				
				'Base\Model\VideoLabelModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new VideoLabelModel($dbAdapter);
				},
				
				'Base\Model\LabelModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new LabelModel($dbAdapter);
				},
				
				'Base\Model\VideoPlayinfoModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						
					return new VideoPlayinfoModel($dbAdapter);
				},
				
				'Base\Model\VideoFilterModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						
					return new VideoFilterModel($dbAdapter);
				},
				
				'Base\Model\RoleModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new RoleModel($dbAdapter);
				},
				'Base\Model\UserRoleModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new UserRoleModel($dbAdapter);
				},
				
				'Base\Model\SubjectModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new SubjectModel($dbAdapter);
				},
				
				'Base\Model\WorkTypeModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new WorkTypeModel($dbAdapter);
				},
				
				'Base\Model\EvaluationModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new EvaluationModel($dbAdapter);
				},
				
				'Base\Model\EvaluationEvaluatorModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new EvaluationEvaluatorModel($dbAdapter);
				},
				
				'Base\Model\EvaluationSortModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new EvaluationSortModel($dbAdapter);
				},
				
				'Base\Model\GaugeModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new GaugeModel($dbAdapter);
				},
				
				'Base\Model\GaugeSortModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new GaugeSortModel($dbAdapter);
				},
				
				'Base\Model\LogModel'  =>  function ($sm) {
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new LogModel($dbAdapter);
				},
				
				'Base\Model\UserCertificateModel' => function ($sm){
					
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
					
					return new UserCertificateModel($dbAdapter);
				},
				
				'Base\Model\LiveClassroomModel' => function ($sm){
						
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
						
					return new LiveClassroomModel($dbAdapter);
				},
				
				'Base\Model\InteractClassroomModel' => function ($sm){
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new InteractClassroomModel($dbAdapter);
				},
				
				'Base\Model\VideoCommentModel' => function ($sm){
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new VideoCommentModel($dbAdapter);
				},
				
				'Base\Model\EvaluationCommentModel' => function ($sm){
				
					$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				
					return new EvaluationCommentModel($dbAdapter);
				},
				
				

//-------------------------------以下为注册过滤器对象----------------------------------------//
				
				//以下为注册过滤对象
				'Base\Filter\ClassroomFilter' =>  function($sm) {
					return new ClassroomFilter();
				},
				
				'Base\Filter\AreaFilter'  =>  function () {
				
					return new AreaFilter();
				},
				
				
				//以下向系统中注册Filter对象
				'Base\Filter\UserFilter' =>  function($sm) {
					return new UserFilter();
				},
				
				'Base\Filter\UserRoleFilter' =>  function($sm) {
					return new UserRoleFilter();
				},
				
				'Base\Filter\RoleFilter' =>  function($sm) {
					return new RoleFilter();
				},
				'Base\Filter\VideoFilter'  =>  function () {
						
					return new VideoFilter();
				},
				
//-----------------------------------资源文件相关的过滤器------------------------------------//				
				'Base\Filter\VideoFilterFilter'  =>  function () {
				
					return new VideoFilterFilter();
				},
				
				'Base\Filter\VideoPlayInfoFilter'  =>  function () {
				
					return new VideoPlayInfoFilter();
				},
				
				'Base\Filter\VideoSortFilter'  =>  function () {
				
					return new VideoSortFilter();
				},
				
				'Base\Filter\VideoLabelFilter'  =>  function () {
				
					return new VideoLabelFilter();
				},
				
				'Base\Filter\LabelFilter'  =>  function () {
				
					return new LabelFilter();
				},
				
				'Base\Filter\CourswareFilter'  =>  function () {
				
					return new CoursewareFilter();
				},
				
				'Base\Filter\CourswareSortFilter'  =>  function () {
				
					return new CoursewareSortFilter();
				},
				
				'Base\Filter\ArticleFilter'  =>  function () {
				
					return new ArticleFilter();
				},
				
				'Base\Filter\ArticleContentFilter'  =>  function () {
				
					return new ArticleContentFilter();
				},
				
				'Base\Filter\ArticleSortFilter'  =>  function () {
				
					return new ArticleSortFilter();
				},
//----------------------------信息相关的过滤器-------------------------------//	

				
				'Base\Filter\SchoolFilter' =>  function($sm) {
					return new SchoolFilter();
				},
				
				'Base\Filter\CertificateFilter' =>  function($sm) {
					return new CertificateFilter();
				},
				
//----------------------------网站页面相关的过滤器-------------------------------//
				
				

				'Base\Filter\LiveClassroomFilter' =>  function($sm) {
					return new LiveClassroomFilter();
				},

				'Base\Filter\InteractClassroomFilter' =>  function($sm) {
					return new InteractClassroomFilter();
				},
				
				
				'Base\Filter\NavigationFilter' =>  function($sm) {
					return new NavigationFilter();
				},
				
				'Base\Filter\PageFilter' =>  function($sm) {
				
					return new PageFilter();
				},
				
				'Base\Filter\ContainerFilter'  =>  function () {
				
					return new ContainerFilter();
				},
				
				'Base\Filter\ElementFilter'  =>  function () {
				
					return new ElementFilter();
				},
//---------------------------教学评价相关的过滤器-----------------------------------//
				
				'Base\Filter\GaugeFilter'  =>  function () {
				
					return new GaugeFilter();
				},

				'Base\Filter\GaugeSortFilter'  =>  function () {
				
					return new GaugeSortFilter();
				},
				
				
				'Base\Filter\EvaluationEvaluatorFilter'  =>  function () {
				
					return new EvaluationEvaluatorFilter();
				},
				'Base\Filter\EvaluationFilter'  =>  function () {
				
					return new EvaluationFilter();
				},
				'Base\Filter\EvaluationSortFilter'  =>  function () {
				
					return new EvaluationSortFilter();
				},				
				
		),

        
    
);
