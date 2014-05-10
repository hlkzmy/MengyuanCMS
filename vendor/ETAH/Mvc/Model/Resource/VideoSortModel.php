<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Sql\Where;



class VideoSortModel extends BaseModel
{
	
	protected $table = 'resource_video_sort';
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * 根据等级获得数据
     * @param int $level
     */
    public function getRowsByLevel($level,$parent_id){
    	if(!is_numeric($level) || !is_numeric($parent_id)){
    		throw new \Exception("参数错误!");
    	}

    	$select = $this->getSql()->select();
    	
    	$where = new Where();
    	
    	$where -> equalTo('level', (int)$level);
    	
    	$where -> equalTo('parent_id', (int)$parent_id);
    	
    	$select->columns(array('id','name'));
    	
    	$select->where($where);
    	
    	$result = $this->selectWith($select)->toArray();
    	
    	return $result;
    	
    }
    
    
   
   
    
}