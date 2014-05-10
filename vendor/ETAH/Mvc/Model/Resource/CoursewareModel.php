<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Sql\Expression;

class CoursewareModel extends BaseModel
{
    protected $table = 'resource_courseware';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * 根据用户的video_id或者video_id数组获得其文档列表
     * @param int|array $video_id
     * @param array $columns
     * @throws \Exception
     * @return array
     */
    
    public function getDocListById($video_id,$columns,$num=10,$flag=true){
    	
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
    	$where -> equalTo("status", 'Y');
    	if($flag){
    		$select->limit($num);
    	}
    	 
    	$select->where($where);
    	 
    	$result = $this->selectWith($select)->toArray();
    	 
    	$result = is_array($result) ? $result : array();
    	 
    	return $result;
    	 
    }
    
    /**
     * 返回上传 文档资源总数
     * @param int|array $video_id
     * @return int
     */
    public function getDocTotalNumber($video_id){
    	 
    	$select = $this->getSql()->select();
    	 
    	$expression = new Expression();
    
    	$expression->setExpression('count(`id`)');
    	 
    	$where = new Where();
    	 
    	if(is_numeric($video_id)){
    
    		$where->equalTo('video_id', $video_id);
    		 
    	}elseif(is_array($video_id)){
    
    		$where->in('video_id',$video_id);
    	}
    
    	$where->equalTo('status', 'Y');
    	 
    	$select->columns(array('num'=>$expression));
    	 
    	$select->where($where);
    	 
    	$result = $this->selectWith($select)->toArray();
    	 
    	return $result[0]['num'];
    }
    
    
    
    
}//class CoursewareModel() end