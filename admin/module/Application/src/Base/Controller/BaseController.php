<?php
namespace Base\Controller;

//加载一些其他的项目
use Etah\Mvc\Controller\BaseController as EtahMvcBaseController;

class BaseController extends EtahMvcBaseController
{
	
	function __construct(){
		date_default_timezone_set('PRC');
		parent::__construct();
		
	}
	
}//function BaseController() end
