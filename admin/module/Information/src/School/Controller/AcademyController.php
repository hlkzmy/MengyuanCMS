<?php

namespace School\Controller;


use Zend\View\Model\ViewModel;
use Base\Controller\BaseController;


class AcademyController extends BaseController{

	
	public function __construct(){
	
	
	}//function __construct() end
	
	
	public function ShowAcademyListAction(){
		
		
		$viewModel = new ViewModel();
		return $viewModel;
	}//function ShowSchoolList() end
	

	

}//function SchoolController
