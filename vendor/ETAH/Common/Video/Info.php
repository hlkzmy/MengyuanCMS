<?php

namespace Etah\Common\Video;

class Info
{
     
	/**
	 * 根据视频路径取得视频的时长，单位是秒,使用ffmpeg_movie的扩展
	 * 示例：D:\Video\H1_d_000.mp4,返回的时长就是60秒
	 */
	public static function getLength($videoPath){
	
		$length = get_f4v_duration($videoPath);
		
		$length = floor(  $length/1000 );
		//毫秒数换算成秒数，并且向下取整
		
		return $length;
	
	}//function getLength() end
	
	public static function getVideoCodec($videoPath){
		
		$ffmpegMovie = new \ffmpeg_movie($videoPath);//新建ffmpeg对象
			
		$videoCodec = $ffmpegMovie->getVideoCodec();//取得视频的时长
			
		unset($ffmpegMovie);
			
		return $videoCodec;
		
	}//function getVideoCodec() end
	
	
	
	
	
	 
	
    
}//class Chapter
