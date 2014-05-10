<?php
namespace Etah\Common\Folder;

class Travel
{
	
	public static function getFileListTotalSize($filePathList,$unit='byte'){
		
		 $totalSize = 0;
		 
		 foreach($filePathList as $filePath){
		 	
		 	$filesize = filesize($filePath);
		 	
		 	$totalSize = $totalSize + $filesize;
		 	
		 }//foreach end
		
		 return $totalSize;
		
	}//function getFileListTotalSize() end
	
	/**
	 * 得到一个文件夹下所有子文件的列表
	 * @param string  $folderPath 指定文件夹的路径
	 * @param array   $extension  指定哪些后缀名的文件将会包含在结果列表中,后缀名不包含点号
	 * @param bool    $completedFilePath 返回结果对象的时候是只返回文件名还是返回完成路径
	 */
	
	public static function getChildFileList($folderPath,$extension=null,$completedFilePath=false){
	
		//echo $folderPath;
	
		$result = array();
	
		$it = new \RecursiveDirectoryIterator($folderPath);
	
		foreach(new \RecursiveIteratorIterator($it) as $element){
	
			if($completedFilePath==true){
				$filename = sprintf("%s/%s",$element->getPath(),$element->getFilename());
			}
			else if($completedFilePath==false){
				$filename = $element->getFilename();
			}
			else{
				throw new \Exception('遍历文件夹下的文件列表的函数第三个参数'.$completedFilePath.'设置错误');
			}
				
			if($extension!=null && is_array($extension)){
	
				$fileExtension = $element->getExtension();
	
				if(in_array($fileExtension,$extension)){
					array_push($result,$filename);
				}
	
			}
			else{
				array_push($result,$filename);
					
			}
				
		}
	
		return $result;
	
	}
	
	
}