<?php

namespace Etah\Common\Video;

class Thumb
{
    private $thumbSize = null;
    //生成的缩略图的大小，格式为【宽度】小写字母x【高度】

    private $videoPath = null;
    //生成的缩略图的文件的路径
    
    private $thumbBaseName = null;
    //生成的缩略图的文件名的基准名称，比如xxxxxxxx_167x86.jpg,基准名称就是xxxxxxxx
    
    
    public function setThumbPath($thumbPath){
    	
    	$this->thumbPath = $thumbPath;
    	
    	return $this;
    }//function setThumbPath();
    
    public function getThumbPath(){
    	
    	return $this->thumbPath;
    	
    }//function getThumbPath() end
    
    
    public function setThumbBaseName($thumbBaseName){
    	
    	$this->thumbBaseName = $thumbBaseName;
    	
    	return $this;
    	
    }//function getThumbBaseName() end
    
    public function getThumbBaseName(){
    	return $this->thumbBaseName;
    }//function getThumbBaseName() end
    
    
	public  function setThumbSize($thumbSize){
		
		$this->thumbSize = $thumbSize;
		
		return $this;
	}//function setThumbSize() end
	
	public function setVideoPath($videoPath){
	
		$this->videoPath = $videoPath;
	
	}//function setThumbSize() end
	
	/**
	 * 根据传递进来的数组生成视频的缩略图文件
	 */
	public function generate(){
		
		if($this->thumbSize==null){
			throw new \Exception('生成视频缩略图的时候没有指定缩略图的大小');
		}
		
		if($this->videoPath==null){
			throw new \Exception('生成视频缩略图的时候没有指定视频的路径');
		}
		
		if(!file_exists($this->videoPath)){
			throw new \Exception('指定的视频的文件在文件系统不存在');
		}
		
		//第一步：得到视频的文件名并且得到视频的缩略图的路径  和 基准文件名称
		
		$videoFileName = basename($this->videoPath);
		//视频缩略图的名称是根据文件名产生的
		
		$thumbBaseName = md5($videoFileName);
		
		//得到缩略图的名称
		
		$thumbPath = sprintf("%s/%s_%s.jpg",dirname($this->videoPath),$thumbBaseName,$this->thumbSize);
		//拼接缩略图的完整的路径
		
		$this->setThumbBaseName($thumbBaseName);
		//设置成员变量，然后可以在之后的代码中取得到缩略图的基准名称
		
		$this->setThumbPath($thumbPath);
		//设置成员变量，然后可以在之后的代码中取得到缩略图的完整路径
		
		
		//第二步：调用ffmpeg扩展生成视频的缩略图
		
		$ffmpegMovie = new \ffmpeg_movie($this->videoPath);//新建ffmpeg对象
		 
		$frameCount = $ffmpegMovie->getFrameCount();
		
		$frameRate  = $ffmpegMovie->getFrameRate();
		
		//echo $this->videoPath.":".$frameCount.':'.$frameRate.":".$frameCount/$frameRate.'<br/>';
		
		$frameNumber = round( $frameCount/$frameRate );
		
		$ffmpegFrame = $ffmpegMovie->getFrame($frameNumber);//得到ffmpeg的帧对象,取第240帧
		 
		$ffmpegImage = $ffmpegFrame->toGDImage();//把得到的帧对象转换成为图像对象
		 
		imagejpeg($ffmpegImage,$thumbPath);//调用imagejpeg生成图像
		 
		imagedestroy($ffmpegImage);//销毁图像对象，因为已经写入到文件中去了
		
		unset($ffmpegMovie);
	}//function generate() end
	 
	
    
    
}//class Chapter
