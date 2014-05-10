<?php

namespace Etah\Common\OperationSystem;

class Info
{
	
	public static function getOperationSystem($userAgentString) {
		
		if(stripos($userAgentString,'windows')){
			return 'windows';
		}
		else if(stripos($userAgentString,'android')){
			return 'android';
		}
		else if(stripos($userAgentString,'iPad')||stripos($userAgentString,'iPhone')){
			return 'ios';
		}
		else if(stripos($userAgentString,'linux')){
			return 'linux';
		}
		else{
			return 'unknown';
		}
		
	}//getBrowser
    
    
}//class  Info() end
