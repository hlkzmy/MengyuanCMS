<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;

class VideoPlayinfoModel extends BaseModel
{
    protected $table = 'resource_video_playinfo';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    /**
     * 根据指定的视频ID 和 指定的章节数查询到视频文件的列表
     */
    public function GetVideoFileList($id,$ChapterNumber){
    
    	//设定查询条件
    	$where =  new where();
    	
    	$where->equalTo('id',$id);
    	
    	$where->equalTo('chapter_number', $ChapterNumber);
    	
    	//选择字段
    	$columns = array('id','filename','length');
    	
    	$select = $this->getSql()->select();
    	
    	$select->where($where);
    	 
    	$select->columns($columns);
    	
        $result =  $this->selectWith($select)->toArray();
    	
    	return $result;
    }//function GetVideoPlayinfoByVideoId() end
    
    
    /**
     * 在没有传递章节数的时候，默认从最小的章节数开始播放，从视频播放列表中查询出最小的章节数
     * @param unknown_type $id
     * @return mixed
     */
    
    public function GetMinimumChapterNumberById($id){
    
    	$where =  new where();
    	
    	$where->equalTo('id',$id);
    	
    	$select = $this->getSql()->select();
    	
    	$select->where($where);
    	
    	$select->columns(array('chapter_number'));
    	
    	$result = $this->selectWith($select)->toArray();
    	
    	$chapterNumberArray = array();
    	
    	foreach($result as $value){
    		array_push($chapterNumberArray,$value['chapter_number']);
    	}
        
    	sort($chapterNumberArray);
    	
    	$chapterNumber = array_shift($chapterNumberArray);
    	
    	return $chapterNumber;
    	
    }//function GetVideoMinimumChapterNumber() end
    
    
    
    
    
    
}