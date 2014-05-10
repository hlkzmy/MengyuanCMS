<?php

namespace Etah\Common\Folder;

class Permission
{

	public static function checkDirectory($path = null)
	{
	
		if(is_null($path)){
			throw new \Exception('目录不能为空');
		}
		
		if(!is_dir($path)) {
	
			throw new \Exception($path.'目录不存在');
				
		}
	
		if(!is_writeable($path)) {
				
			throw new \Exception('目录'.$path.'不可写');
		}
	
	
		return $path;
	
	}

}