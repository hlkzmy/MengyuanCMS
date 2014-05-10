<?php
namespace Etah\Mvc\Model\Evaluate;

use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Adapter\Adapter;


class ExcellentVideoModel extends BaseModel
{
    protected $table = 'evaluate_excellent_video';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    public function getVideoListById($id) {
    	$select = $this->getSql()->select();
    	$columns = array('video_id');
    	$select->columns($columns);
    	
    	$where = $select->where;
    	$where->equalTo('id', $id);
    	
    	//echo $select->getSqlString();exit();
    	$result = array();
    	$resultSet = $this->selectWith($select)->toArray();
    	if(!empty($resultSet)) {
    		foreach ($resultSet as $v) {
    			$result[] = $v['video_id'];
    		}
    		return $result;
    	} else {
    		return $result;
    	}
    }
}//class ArticleModel() end