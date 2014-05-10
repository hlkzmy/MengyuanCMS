<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Mvc\Plugin\Log;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService as AuthenticationService;
use Etah\Common\Client\client;


class LogManager extends AbstractPlugin
{
	
	
	public function __construct()
	{
		$auth = new AuthenticationService();
		
		if($auth->hasIdentity()){
			$this->user = $auth->getIdentity();
		}
		
	}//function __construct() end
	

	
	public function writeLogs($e)
	{	
		
		//第一部分：得到模块、控制器与方法的名称与路由，用于在下面调用
		$serviceManager = $e->getApplication()->getServiceManager();
		//得到服务管理者对象
		
		$configure = $serviceManager->get('config');
		//得到配置对象
		
		$RouteParamList = $this->getRouteParamList($e,$serviceManager);
		
		$modulePath 	= $RouteParamList['module_path'];
		$controllerPath = $RouteParamList['controller_path'];
		$actionPath 	= $RouteParamList['action_path'];
		
		$node = array();
		array_push($node, $modulePath);
		array_push($node, $controllerPath);
		array_push($node, $actionPath);
		
		//第二部分：取得需要记录的数据并处理数据
		
		//1.取得路由数据
		
		$nodeModel     = $serviceManager->get('Base/Plugin/Logs/Model/NodeModel');
		
		$where = new Where();
		$where->in('name',$node);
		$columns = array('id','name','title');
		$tempList = $nodeModel->getRowByCondition($where, $columns);
		
		$routeParamNameList = array();
		
		foreach ($tempList as $routeParamName){
			$routeParamNameList[$routeParamName['name']] = $routeParamName['title'];
		}
		
		
		$projectName = PROJECT_NAME;
		$moduleName = isset($routeParamNameList[$modulePath])?$routeParamNameList[$modulePath]:'未知模块'.$modulePath;
		$controllerName = isset($routeParamNameList[$controllerPath])?$routeParamNameList[$controllerPath]:'未知控制器'.$controllerPath;
		$actionName = isset($routeParamNameList[$actionPath])?$routeParamNameList[$actionPath]:'未知方法'.$actionPath;
		
		//2.取得参数数据
		
		$params = $e->getRouteMatch()->getParams();
		
		unset($params['__NAMESPACE__']);
		unset($params['controller']);
		unset($params['action']);
		unset($params['__CONTROLLER__']);
		
		$get = $e->getRequest()->getQuery()->toArray();
		unset($get['_']);
		
		$parameter['fromRoute'] = $params;
		$parameter['get'] = $get;
		
		
		
		//3.取得ip
		
		$ip  = client::getClientIp();
		
		
		//4.取得用户数据
		$auth = new AuthenticationService();
		
		if (!$auth->hasIdentity()){
			$realname = 'unknow';
		}else{
			
			$realname = $auth->getIdentity()->realname;
			
		}
		
		
		
		//5.取得时间数据
		date_default_timezone_set('Asia/Shanghai');
		$dateNow = date("Y-m-d H:i:s");
		
		
		//数据汇总
		$data = array(
		
				'dtime'			=>$dateNow,
				'realname'		=>$realname,
				'project'		=>$projectName,
				'application'	=>$moduleName,
				'controller'	=>$controllerName,
				'action'		=>$actionName,
				'parameter'		=>json_encode($parameter),
				'ip'			=>$ip,
		
		
		);
		
		//第三部分，得到相关的模型并插入数据
		
		$dbConfigure = $configure['db'];
		
		$adapter = new Adapter($dbConfigure);
		
		$tableName = 'system_log_'.date('Y').'_'.date('m');
		
		$logUserOperationModel = new TableGateway($tableName, $adapter);
		
		//插入数据
		$logUserOperationModel->insert($data);

    }
    

    
    private function getRouteParamList($e,$serviceManager){
    
    	$routeMatch = $e->getRouteMatch();
    	//得到路由匹配对象
    
    	$routeMatchParam = $routeMatch->getParams();
    	//得到路由配置对象的参数
    
	    $module 	= strtolower(substr($routeMatchParam['__NAMESPACE__'], 0,strpos($routeMatchParam['__NAMESPACE__'], '\\')));
    	//得到模块的名称
    
    	$controller = $routeMatchParam['__CONTROLLER__'];
    	//得到控制器的名称
    
    	$action		= $routeMatchParam['action'];
    	//得到方法的名称
    
    	$param = array();
    
    	$param['module_path'] = strtolower($module);
    
    	$param['controller_path'] = strtolower($controller);
    
    	$param['action_path'] = strtolower($action);
    
    	return $param;
    
    }//function getRouteParamList() end
    
	

}