<?php

namespace Etah\Common\Video;

class Format
{
     
	/**
	 * @param $videoFilePath 视频文件的硬盘路径，包括文件夹的文件名
	 * 根据传递进来的数组生成视频的缩略图文件
	 */
	public static function f4vToMp4($videoFilePath){
		
		
		if(!file_exists(F4VCONVERT_DISK_PATH)){
			throw new \Exception('系统所指定的f4vConvertor.exe的路径不存在');
		}
		
		if(!is_executable(F4VCONVERT_DISK_PATH)){
			throw new \Exception('系统所指定的f4vConvertor.exe的不是有效的exe文件');
		}
		
		
		$videoDirectoryPath = dirname($videoFilePath);
		
		$filename = basename($videoFilePath);
		
		$command  = sprintf("cd %s&&",$videoDirectoryPath);
			
		$command .= sprintf("%s %s",F4VCONVERT_DISK_PATH,$filename) ;
		
		@system($command);
		
	}//function f4vToMp4();
	 
	
    
    
}//class Chapter
