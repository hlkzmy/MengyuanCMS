<?php
/**
 * 得到成员变量的取值，然后返回成员变量的
 * @author hlkzmy
 *
 */

namespace Etah\Mvc\Factory\Regist;

class MemberVariable{

	
	public static function getDatabaseModel($serviceManager, $applicationName, $folderName, $modelName){
		
		$path = $applicationName . "/" . $folderName . "/" . $modelName;
		
		$model = $serviceManager->get ( $path );
		
		return $model;
		
	}//function getDatabaseModel() end
	
	public static function getForm($serviceManager, $applicationName, $folderName, $formName){
		
		$path = $applicationName . "/" . $folderName . "/" . $formName;
		
		$form = $serviceManager->get ( $path );
		
		return $form;
	
	}//function getForm() end
	
	public static function getFilter($serviceManager, $filterName){
		
		$path =  'Base/Filter/'. $filterName;
		
		$filter = $serviceManager->get ( $path );
		
		return $filter;
		
	}//function getFilter
	
	 
	
	
	
	
	
	
}//class MemberVariable() end


?>