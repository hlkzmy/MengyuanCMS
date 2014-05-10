<?php

namespace Etah\Common\Video;

class Chapter
{
     
	/**
	 * 根据视频名称的通过截取字符串的方法，然后获得章节数
	 * 示例：H1_d_000.mp4,返回的章节数就是0
	 * 	   H1_d_001.mp4,返回的章节数就是1
	 */
	public static function returnChapterNumberByFilename($filename){
	
		$ChapterNumberInfo = substr($filename,strlen($filename)-3);
	
		$ChapterNumber = intval($ChapterNumberInfo);
	
		return $ChapterNumber;
	
	}//function ReturnChapterNumberByFilename() end
	 
	
    
    
}//class Chapter
