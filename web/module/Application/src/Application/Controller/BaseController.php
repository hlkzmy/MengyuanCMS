<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class BaseController extends AbstractActionController
{
	
	public function __construct(){
		
				
	}
	
	
   	final protected  function ajaxReturn($statusCode, $message,$data) {
    	
   		$return = array();
   		$return['statusCode']   = intval($statusCode);
   		$return['message'] 		= strval($message);
    	
   		if(!is_null($data)){
   			$return['data'] = $data;
   		}
   		
    	exit ( json_encode ( $return ) );
    }
    
}
