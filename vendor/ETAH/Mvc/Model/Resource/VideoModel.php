<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel; 
use Zend\Db\Sql\Expression;

class VideoModel extends BaseModel
{
    protected $table = 'resource_video';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * 返回上传视频资源总数
     * @param int|array $userId
     * @return int
     */
    public function getVideoTotalNumber($userId){
    	
    	$select = $this->getSql()->select();
    	
    	$expression = new Expression();
    	 
    	$expression->setExpression('count(`id`)');
    	
    	$where = new Where();
    	
    	if(is_numeric($userId)){
    		
    			$where->equalTo('user_id', $userId);
    	
    		}elseif(is_array($userId)){
    		
				$where->in('user_id',$userId);    		
    	}
    	 
    	$where->equalTo('status', 'Y');
    	
    	$select->columns(array('num'=>$expression));
    	
    	$select->where($where);
    	
    	$result = $this->selectWith($select)->toArray();
    	
    	return $result[0]['num'];
    }
    
    /**
     * 获取视频添加人的ID排行榜
     * 
     */
    
    public function getVideoRankingsList($limit)
    {
    	$expression = new Expression();
    	
    	$expression->setExpression('count(`id`)');
    	
    	$where = new Where();
    	
    	$where->notEqualTo('user_id', '');
    	
    	$where->equalTo('status', 'Y');
    	
    	$where->equalTo('download_status', 'finished');
    	
    	$where->equalTo('translate_status', 'Y');
    	
    	$select = $this->getSql()->select();
    	
    	$select->columns(array('num'=>$expression,'user_id'));
    	
    	$select->where($where);
    	
    	$select->group('user_id');
    	
    	$select->order('num Desc');
    	
    	$select->limit($limit);
    	
    	$result = $this->selectWith($select)->toArray();
    	
    	return $result;
    	
    }
    
    /**
     * 根据用户的id或者id数组获得其视屏列表
     * @param int|array $id
     * @param array $columns
     * @throws \Exception
     * @return array
     */
    
    public function getVideoListById($id,$columns,$num=10,$flag=true,$order="add_time desc"){
    	
    	$select = $this->getSql()->select();
    	
    	$where = new Where();
    	
    	if(!count($columns)){
    		throw new \Exception("必须设置字段参数");
    	}
    	
    	$select->columns($columns);
    	
    	if(is_numeric($id)){
    		
    		$where -> equalTo("user_id", $id);
    		
    	}elseif(is_array($columns)){
    		
    		$where -> in('id',$id);		
    		
    	}else{
    		throw new \Exception("参数一类型非法");
    	}
    	
    	$where->equalTo('status','Y');
    	$where->equalTo('download_status','finished');
    	$select->join('resource_video_playinfo', 'resource_video.id = resource_video_playinfo.id',array('length'),'right');
    	
    	if($flag){
    		$select->limit($num);
    	}
    	$select->order($order);
    	$select->where($where);
    	
    	$result = $this->selectWith($select)->toArray();
    	$idArr = array();
    	foreach ($result as $k=>$v){
    		if(in_array($v['id'], $idArr)){
    			unset($result[$k]);
    		}else{
    			$idArr[] = $v['id'];
    		}
    	}
    	$result = is_array($result) ? $result : array();
    	
    	return $result;
    	
    }
    
    //根据条件获得数据
    public function getRowsByCondition($where,$columns = null,$order=NULL){
    	
    	$select = $this->getSql()->select();
    	
    	if($columns!==null){
    		//如果字段被设置了的话，就加载字段
    		$select->columns($columns);
    	}
    	
    	if($order!=null){
    		//如果排序被设置了的话，就加载排序
    		$select->order($order);
    	}
    	
    	$select->where($where);
    	
    	$result = $this->selectWith($select)->toArray();
    	
    	return $result;
    		
    	
    }
    
    
    
}//class VideoModel() end