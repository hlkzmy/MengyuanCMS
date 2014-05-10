<?php

namespace Etah\Common\ArrayOperation;


class Travel
{
     
	public static function depthFirst($array,&$pathList,$parentKey=''){
		
		foreach($array as $key=>$subArray){
		
				if(is_array($subArray)){
						
					if(trim($parentKey)==''){
						$path = $key;
					}
					else{
						$path = $parentKey.'-'.$key;
					}
						
					self::depthFirst($subArray,$pathList,$path);
				}
				else{
					
					if(trim($parentKey)==''){
						$path = $key;
					}
					else{
						$path = $parentKey.'-'.$key;
					}
					
					$data = array('path'=>$path,'value'=>$subArray);
					
					array_push($pathList,$data);
					
				}
			}//foreach end
		
	}//function depthFirstTravel() end
	
	
	/**
	 * 在数组中根据一个元素然后找到这个元素的子孙元素
	 * @param unknown_type $element
	 * @param unknown_type $containerList
	 * @return multitype:unknown
	 */
	public static function getDescendantContainerList($element,$containerList){
		//根据$id 和 一个以id为键名的数组，查找出$id的子数组
	
		$descendantContainerList = array();
	
		foreach($containerList as $key=>$container){
	
			if( ($container['left_number']>$element['left_number']) && ($container['right_number']<$element['right_number']) ){
	
				$descendantContainerList[$key] = $container;
			}
			 
		}//foreach end
	
		return $descendantContainerList;
	
	}//function getDescendantContainerList() end
	
	
	
}//class Travel
