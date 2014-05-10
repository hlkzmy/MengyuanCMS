<?php

namespace Etah\Common\Folder;

class Folder
{
	private static  $method = 'recursion';
	
	
	
	public static function setMethod($method)
	{
		self::$method = $method;
	}
	
	public static function create($path){
	
		if(self::$method == 'recursion'){
			
			self::createDirectory($path);
			
		}elseif(self::$method == 'circulate'){
			
			self::createLinuxDirectory($path);
		}
	
	}
	
	/**
	 *递归方式创建文件夹
	 *@param unknown_type $path
	 *@throws \Exception
	 */
	private static function createDirectory($path){
		//循环创建文件夹，保证路径传递进来一定有文件夹形成
	
		if (!file_exists($path)){
	
			self::createDirectory(dirname($path));
			
			if (!mkdir($path, 0777)){
				throw new \Exception('目录不能被正确创建');
		
			}
	
		}
	
	}//function createDirectory() end

	/**
	 * 用循环的方式创建文件夹   linux适用
	 * @param unknown_type $path
	 * @throws \Exception
	 */
	
	private static function createLinuxDirectory($path){
		$adir = explode ( '/', $path );
		$dirlist = '';
		$rootdir = array_shift ( $adir );
		if (($rootdir != '.' || $rootdir != '') && ! file_exists ( $rootdir )) {
			if (!mkdir ( $rootdir )){
				throw new \Exception('目录不能被正确创建');
			}
		}
		foreach ( $adir as $key => $val ) {
			$dirlist .= "/" . $val;
			$dirpath = $rootdir . $dirlist;
			if (file_exists ( $dirpath )) {
				
				if (!mkdir ( $dirpath ) || !chmod ( $dirpath, 0777 )){
					throw new \Exception('目录不能被正确创建');
				}
				
			}
		}
	}
	
    
    
}//class Chapter
