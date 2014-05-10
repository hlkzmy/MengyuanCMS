<?php
namespace Etah\Mvc\Plugin\Permission\Model;


use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class MenuModel extends BaseModel {
	
	protected $table = 'system_menu';
	
	public function __construct(Adapter $adapter) {
		$this->adapter = $adapter;
		$this->initialize ();
	}
	
	public function getMenuItemList(){
		
		$select= $this->getSql()->select();
		
		$select->columns(array(	'id',
								'label'=>'title',
								'module_name',
								'controller_name',
								'action_name',
								'level',
								'parent_id')
						);
		
		$where = new Where();
		$where->equalTo('status','Y');
		
		$select->where($where);
		$select->order(array('left_number'=>'desc'));
		
		return $this->selectWith($select)->toArray();
		
	}//function getNodeList() end
   
    
   
}