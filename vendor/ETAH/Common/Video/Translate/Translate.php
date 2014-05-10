<?php
namespace Etah\Common\Video\Translate;

/**
 * 调用ffmpeg.exe来对视频进行转码
 * 使用的是命令行的模式
 * 本例只负责把其它格式转换成mp4格式
 * 
 * @author Edward_sj
 */


class Translate
{
	
	private $sourceVideoPath;
	
	private $targetVideoPath;
	
	//想要转换成的后缀名
	private $targetExtension = 'mp4';
	
	//FFmpeg.exe 的路径
	private $FFmpeg;
	
	//logPath 
	private $logPath;
	
	//是否删除源文件
	private $unlinkSourceVideo = true;
	
	public function __construct(){
		
	}
	
	public function setSourceVideoPath($path)
	{
		$this->sourceVideoPath = $path;
		return $this;
	}
	
	public function getSourceVideoPath()
	{
		return $this->sourceVideoPath;
	}
	
	
	public function setTargetVideoPath($path)
	{
		$this->targetVideoPath = $path;
		return $this;
	}
	
	public function getTargetVideoPath()
	{
		return $this->targetVideoPath;
	}
	
	public function ffmpegPath($path)
	{
		$this->FFmpeg = $path;
		return $this;
	}
	
	public function setUnlinkSourceVideo($boolean)
	{
		$this->unlinkSourceVideo = $boolean;
		return $this;
	}
	
	private function getBaseName($sourcePath)
	{
		$name = basename($sourcePath);
		
		$ext = strrchr($name, '.');
		
		$baseName = substr($name, 0,(strlen($name)-strlen($ext)));
		
		return $baseName;
	}
	
	
	private function parametersChecked()
	{
		
		if(!is_file($this->sourceVideoPath))
		{
			file_put_contents($this->FFmpeg.'TraslateLog.log', '指定的源文件路径不存在或不正确'."\r\n",FILE_APPEND);
			throw new \Exception('指定的源文件路径不存在或不正确');
			
		}elseif (!is_dir(dirname($this->targetVideoPath))){
			
			file_put_contents($this->FFmpeg.'TraslateLog.log', '指定的目标文件路径不存在或不正确'."\r\n",FILE_APPEND);
			throw new \Exception('指定的目标文件路径不存在或不正确');
		}
		
		
	}
	
	
	public function doTraslate(){
	
		$translateInfo = array();
		
		$baseName = $this->getBaseName($this->sourceVideoPath).'.mp4';
		
		$this->targetVideoPath = dirname($this->sourceVideoPath).'/'.$baseName;
		
		$temp = dirname($this->sourceVideoPath).'/_'.$baseName;
		
		file_put_contents($this->FFmpeg.'TraslateLog.log', $this->targetVideoPath."\r\n",FILE_APPEND);
		//参数检查
		
// 		$this->parametersChecked();
				 
		$command =  $this->FFmpeg.'ffmpeg.exe -i '.$this->sourceVideoPath;
		
		$command .= ' -ab 128 -acodec aac -strict experimental -ac 1 -ar 22050 -vcodec h264 -r 29.97 -qscale 6 -y '.$temp;
		 
		file_put_contents($this->FFmpeg.'TraslateLog.log', 'traslate Strat  '."\r\n",FILE_APPEND);
		 
		// 视频开始转换
		exec($command,$out,$status);
		
		if($status==0){
		
			file_put_contents($this->FFmpeg.'TraslateLog.log', 'traslate Success '."\r\n",FILE_APPEND);
		

			if ($this->unlinkSourceVideo){
				unlink($this->sourceVideoPath);//删除原文件
			}
			
			rename($temp, $this->targetVideoPath);
			

			
		}else{
		
			file_put_contents($this->FFmpeg.'TraslateLog.log', 'traslate Fail NO '.$status."\r\n",FILE_APPEND);
			file_put_contents($this->FFmpeg.'TraslateLog.log', $command ."\r\n",FILE_APPEND);
			
			throw new \Exception('视频转码失败，错误代码为'.$status);
		}
	
	}
	
}