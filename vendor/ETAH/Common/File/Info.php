<?php

namespace Etah\Common\File;

class Info
{
     
	/**
	 * 根据视频路径取得视频的时长，单位是秒,使用ffmpeg_movie的扩展
	 * 因为php自带的函数filesize取得文件大小是byte, 返回的文件大小将根据单位进行转换
	 */
	public static function getFormatFilesize($filePath,$unit='byte'){
	
		$unit = strtolower($unit);
		
		switch($unit){
			
			case 'byte':$divisor=1;break;
			case 'kb':$divisor=1024;break;
			case 'mb':$divisor=1024*1024;break;
			case 'gb':$divisor=1024*1024*1024;break;
			
			default:throw new \Exception('取得文件大小的时出错，文件大小的单位超过了支持的范围');
		
		}
		
		$filesize = floor( filesize($filePath) / $divisor );

		return $filesize;
		
	}//function getFormatFilesize() end
	
	
	/**
	 * 传递一个文件的路径，然后返回文件的mime信息数组
	 * 数组的type键值是mime的类型，数组的charset是文件的编码方法，一般意义上都是binary
	 * @param string $filePath
	 * @throws \Exception
	 * @return array $mimeInfoArray
	 */
	
	public static function getMimeInfo($filePath){
		
		if(!extension_loaded('fileinfo')){
			throw new \Exception('取得文件的MIME信息的php扩展fileinfo没有被加载');
		}
		
		$finfo    = finfo_open(FILEINFO_MIME);
		
		$mimeInfo = finfo_file($finfo, $filePath);
		
		finfo_close($finfo);
		
		$array = explode(';', $mimeInfo);
		
		$mimeInfoArray = array( 
								'type'=> trim($array[0]) ,
								'charset'=>trim($array[1])
							  );
		
		return $mimeInfoArray; 
		
	}//function getMimeType() end
	
	
	
	
	
	
	
	 
	
    
}//class Chapter
