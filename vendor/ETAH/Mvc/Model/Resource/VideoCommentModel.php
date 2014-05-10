<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\sql\Where;

class VideoCommentModel extends BaseModel
{
    protected $table = 'resource_video_comment';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    /**
     * 根据用户的video_id或者video_id数组获得其评论列表
     * @param int|array $video_id
     * @param array $columns
     * @throws \Exception
     * @return array
     */
    
    public function getCommentListById($video_id,$columns,$num=10,$flag=true){
    	
    	$select = $this->getSql()->select();
    
    	$where = new Where();
    
    	if(!count($columns)){
    		throw new \Exception("必须设置字段参数");
    	}
    
    	$select->columns($columns);
    
    	if(is_numeric($video_id)){
    
    		$where -> equalTo("video_id", $video_id);
    
    	}elseif(is_array($columns)){
    
    		$where -> in('video_id',$video_id);
    
    	}else{
    		throw new \Exception("参数一类型非法");
    	}
    	$where -> equalTo("resource_video_comment.status", 'Y');
    	$where -> equalTo("information_user.status", 'Y');
    	
    	if($flag){
    		$select->limit($num);
    	}
    
    	$select->where($where);
    	
    	$select->join('information_user', 'resource_video_comment.user_id = information_user.id',array('username','photo','realname','uid'=>'id'),'left');
    	    	
    	$result = $this->selectWith($select)->toArray();
    
    	$result = is_array($result) ? $result : array();    	
    	
    	
    	return $result;
    
    }
    
}