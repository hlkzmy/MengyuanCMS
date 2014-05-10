<?php
namespace Etah\Mvc\Model\System;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class AreaModel extends BaseModel
{
    protected $table = 'system_area';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    public function getProvinceList($field=null){
    	
    	$where = new Where();
    	
    	$where->equalTo('level',2);
    	 
    	$select = $this->getSql()->select();
    	
    	$select->where($where);
    	
    	if($field==null){
    		$select->columns(array('id','name'));
    	}
    	else{
    		$select->columns($field);
    	}
    	
    	$result = $this->selectWith($select)->toArray();
    	
    	return $result;
    	
    }//function getProvinceList() end
    
    
    public function getProvinceSelectOptions(){
    	 
    	$result = $this->getProvinceList(); 
    	 
    	$selectOptions = array('0'=>'请选择省份');
    	 
    	foreach($result as $value){
    
    		$selectOptions[  $value['id'] ] = $value['name'];
    
    	}
    	 
    	return $selectOptions;
    	 
    }//function getProvinceSelectOptions() end
    
    
    public function getSubAreaSelectOptions($id){
    	 
    	$parentAreaInfo = $this->getRowById($id,array('level'));
    	$parentAreaLevel = $parentAreaInfo['level'];
    	 
    	$subAreaWhere =  new Where();
    	$subAreaWhere->equalTo('display', 'Y');
    	 
    	$subAreaList = $this->getSubRowById($id,array('id','name'),$subAreaWhere);
    	 
    	return $this->convertArrayToSelectOptions($parentAreaLevel,$subAreaList);
    	 
    }//function getSubAreaSelectOptions() end
    
    private function convertArrayToSelectOptions($level,$array){
    	 
    	$selectOptions = array();
    	 
    	foreach($array as $value){
    		 
    		$selectOptions[  $value['id'] ] = $value['name'];
    		 
    	}
    
    	return $selectOptions;
    	 
    }//function convertArrayToSelectOptions() end
    
    
    
}//class SchoolModel() end