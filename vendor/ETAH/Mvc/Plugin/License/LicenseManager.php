<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Mvc\Plugin\License;

use Zend\View\Model\ViewModel;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Authentication\AuthenticationService as AuthenticationService;


class LicenseManager extends AbstractPlugin
{
	
	
	public function __construct()
	{
		$this->LimitInfo = get_limit_info();
		//通过PHP扩展函数得到限制信息
		
		$this->SoftwareInfo = get_software_info();
		//通过PHP扩展函数得到软件信息
		
		$this->UserInfo = get_user_info();
		//通过PHP扩展函数得到用户信息
		
	}//function __construct() end
	

	
	public function checkLicense($e)
	{	
		
		//第一部分：得到模块、控制器与方法的名称与路由，用于在下面调用
		$serviceManager = $e->getApplication()->getServiceManager();
		//得到服务管理者对象
		
		$configure = $serviceManager->get('config');
		//得到配置对象
		$render = $serviceManager->get( 'Zend\View\Renderer\PhpRenderer' );
		$viewModel = new ViewModel();
		$viewModel->setTemplate('error/error');
		$viewModel->setVariable('message', "系统授权错误");
		
		if($this->LimitInfo['status'] !=200){
			$viewModel->setVariable('information', "获取系统授权信息错误，错误代码".$this->LimitInfo['status']);
			$html = $render->render($viewModel);
			die($html);
		}
		
		if($this->SoftwareInfo['status'] !=200){
			$viewModel->setVariable('information', "获取系统限制信息错误，错误代码".$this->SoftwareInfo['status']);
			$html = $render->render($viewModel);
			die($html);
		}

		if($this->SoftwareInfo['info']['software_name'] != 'PHP_RESOURCE_PLATFORM'){
			$viewModel->setVariable('information', "系统授权信息不正确，该授权不适用于此版本");
			$html = $render->render($viewModel);
			die($html);
			
		}
		
		
			
    }
    
	

}