<?php

namespace Etah\Common\ArrayOperation;


class Key
{
     
	/**
	 * 把一个二维数组的键名更改成为指定的字符串
	 * @param array  $array
	 * @param string $key
	 */
	public static function changeArrayKey($sourceArray,$targetKey)
	{
		$targetArray = array();
		 
		foreach($sourceArray as $element){
			 
			$targetArray[$element[$targetKey]] = $element;
			 
		}//foreach end
		 
		return $targetArray;
	
	}//function changeArrayKey() end
	
	
	
    
    
}//class Travel
