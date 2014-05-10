<?php
namespace Etah\Mvc\Model\Information;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class UserCertificateModel extends BaseModel
{
    protected $table = 'information_user_certificate';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * 根据用户的id或者id数组获得其证书列表
     * @param int|array $id
     * @param array $columns
     * @throws \Exception
     * @return array
     */
    
    public function getCertificateListById($id,$columns,$num=10,$order="add_time desc"){
    	 
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
    	 
    	$select->limit($num);
    	$select->order($order);
    	$select->where($where);
    	
    	$result = $this->selectWith($select)->toArray();
    	 
    	$result = is_array($result) ? $result : array();
    	 
    	return $result;
    	 
    }
    
}//class SchoolModel() end