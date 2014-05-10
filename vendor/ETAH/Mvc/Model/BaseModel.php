<?php
namespace Etah\Mvc\Model;

use Zend\Validator\IsInstanceOf;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;


class BaseModel extends TableGateway
{
	
	const INSERT_NODE   = 'insert';
	const DELETE_NODE   = 'delete';
    
        /**
         * 更新pv值
         * @param type $where
         * @param type $column
         * @throws \Exception
         */
        public function addPvByCondition($where,$column){
                if(!is_array($where) || count($where) == 0){
		throw new \Exception('请填写筛选条件!');
	}
                if(is_string($column)){
                            $select = $this->getSql()->select();
                            $select->where($where);
                            $rows = array('id');
                            array_push($rows, $column);
                            $columns = array_unique($rows);
                            $select->columns($columns);
                            
                            $result = $this->selectWith($select)->toArray();
                         
                            foreach ($result as $value) {
                                $update = $this->getSql()->update();
                                $data = $value[$column] + 1;
                                $update->where(array('id'=>$value['id']));
                                $update->set(array($column=>$data));	
                                if(!$this->updateWith($update)){
			throw new \Exception('更新数据失败，请联系网站管理员');
		}
                            }
                 }else{
                           throw new \Exception('请选择正确字段!');
                     }
        }


        final public function getSubRowById($id,$columns = null,$externalWhere = null,$order = null){
		
		$select = $this->getSql()->select();
		
		$where  = new where();
		
		if($columns!==null){
			//如果字段被设置了的话，就加载字段
			$select->columns($columns);
		}
		
		if($externalWhere!=null){
			//如果条件被设置了的话，就把外置的条件添加到当前的查询条件中
			$where->addPredicate($externalWhere);
		}
		
		if($order!=null){
			//如果排序被设置了的话，就加载排序
			$select->order($order);
		}
		
		if(is_numeric($id)){
				
			$where->equalTo('parent_id', $id);
				
			$select->where($where);
				
			$result = $this->selectWith($select)->toArray();
				
			if($result){
				return $result;
			}
			else{
				return array();
			}
		}
		else{
			
			throw new \Exception('id参数类型不正确，请不要尝试非法输入');
		}
		
	}//function getSubRowById() end
	/**
	 * 根据id查询到数据库的行数
	 * @param int $id || array $id
	 * @param array $columns
	 * @param object $where
	 * @param array $order
	 * @return array || throw Exception
	 * @todo 添加对于调用这个方法的验证，检验存在不存在这个字段 并且检查id是不是主键
	 * @todo 添加对于选取字段的验证，选取的字段是不是都在这个数据表中
	 */
	
	final public function getRowById($id,$columns = null,$externalWhere = null,$order = null,$limit = null){
		
		$select = $this->getSql()->select();
		
		$where  = new where();
		
		if($columns!==null){
		//如果字段被设置了的话，就加载字段	
			$select->columns($columns);
		}
		
		if($externalWhere!=null){
		//如果条件被设置了的话，就把外置的条件添加到当前的查询条件中
			$where->addPredicate($externalWhere);
		}
		
		if($order!=null){
		//如果排序被设置了的话，就加载排序
			$select->order($order);
		}
		
		if($limit!==null){
			if(is_numeric($limit)){
				$select->limit($limit);
			}
			else{
				throw new \Exception('limit字段类型不正确，请不要尝试非法输入');
			}
		}
		
		//根据id的类型来判断查询的选择的条件，是选用equalTo还是in
		if(is_numeric($id)){
			
			$where->equalTo('id', $id);
			
			$select->where($where);
			
			$result = $this->selectWith($select)->toArray();
			
			if($result){
				$row = $result[0];
			}
			else{
				$row = array();
			}
		}
		else if(is_array($id)){
			
			$where->in('id', $id);
			
			$select->where($where);
				
			$row = $this->selectWith($select)->toArray();
			
			if(sizeof($row)==0){
				$row = array();
			}
			
		}
		else{
			throw new \Exception('id参数类型不正确，请不要尝试非法输入');
		}
		
		
		return $row;
		
	}//function getRowById end
	
	
	/**
	 *翻页专用
	 * 根据选取字段(columns)、筛选条件(where)、排序字段(order)、偏移范围(range)来对记录进行筛选的方法
	 * 专门用来在界面上显示数据库记录的列表显示，比如用户列表界面、文章列表界面、视频列表界面
	 * @todo 添加对于columns的合法性验证
	 * @todo 添加对于where的合法性验证
	 * @todo 添加对于order的合法性验证
	 * @todo 添加对于range的合法性验证
	 */
	
	final public function getFilterRowList($columns=null,$where=null,$order=null){
		
		$select = $this->getSql()->select();
		
		if(is_array($columns)){
			$select->columns($columns);
		}
		
		if($where!==null){
			
			if($where instanceof where){
				$select->where($where);
			}
		}
		
		//在换页的时候需要用到总共的行数这个问题，但是不跟offset和limit相关了
		//因为要取得的是符合查询条件的数据库记录的总共的行数
		if(is_array($order)){
			$select->order($order);
		}
		
		$paginatorAdapter = new DbSelect($select,$this->adapter);
		
		$paginator = new Paginator($paginatorAdapter);
		
		return $paginator;
		
	}//function getFilterRowList() end
	
	
	/**
	 * 查询出整张数据表的数据,专门用于返回数据量较小的数据表，用来在界面上显示组件的时候使用
	 * 比如学科表、年级表、工作类型表相同类型的表
	 * @return array;
	 */
	final public function getRowList($columns=null){
		
       $select = $this->getSql()->select();
       
       if(is_array($columns)){
       		$select->columns($columns);
       }
       
       $result = $this->selectWith($select)->toArray();
		
//        print_r($result);
       
	   return  $result;	
		
	}//function getRowList() end
	
	
	/**
	 * 根据id删除数据库记录
	 * @param int $id || array $id
	 * @throws Exception
	 * @todo 添加对于调用这个方法的验证，检验存在不存在这个字段 并且检查id是不是主键
	 */
	final public function deleteRowById($id){
		
		$delete = $this->getSql()->delete();
		
		$where = new where();
		
		if(is_numeric($id)){
			$where->equalTo('id', $id);
		}
		else if(is_array($id)){
			$where->in('id', $id);
		}
		else{
			throw new \Exception('id参数类型不正确，请不要尝试非法输入');
		}
		
		$delete->where($where);
		
		$deleteState = $this->deleteWith($delete);
		
		if($deleteState===false){
			throw new \Exception('删除数据失败，请联系网站管理员');
		}
		
	}//function deleteRowById() end
	
	/**
	 * 根据传递进来的条件删除数据库记录
	 * @param where $where
	 * @throws Exception
	 * @todo 添加对于$where 和 $data合法性的验证
	 */
	final public function deleteRowByCondition($where){
	
		$delete = $this->getSql()->delete();
		
		if($where->count()==0){
			throw new \Exception('删除记录的条件为空或不正确，请不要尝试非法输入');
		}
		
		$delete->where($where);
		
		$deleteState = $this->deleteWith($delete);
		
		if($deleteState===false){
			throw new \Exception('删除数据失败，请联系网站管理员');
		}
		
	}//function deleteRowById() end
	
	
	
	/**
	 * 向数据表中批量的添加数据
	 * @param array $data
	 * @throws \exception
	 * @todo 对于传入的数据做校验
	 * @todo 抛出的异常要包括数据表的表名   和 错误的数据所对应的主键，便于查找错误
	 */
	
	final public function insertRowList($data){
		
		foreach($data as $set){
			
			$insertState = $this->insert($set);
			
			if($insertState==0){
				throw new \exception('向数据表中批量添加数据失败');
			}
		}//foreach end
		
	}//function insertAll() end
	
	/**
	 * 向数据表中添加一条数据
	 * @param array $data
	 * @throws \exception
	 * @todo 对于传入的数据做校验
	 * @todo 抛出的异常要包括数据表的表名   和 错误的数据所对应的主键，便于查找错误
	 */
	
	final public function insertRow($data){
		
		$insert = $this->getSql()->insert();
		
		$insert->into($this->table);
		
		$insert->values($data);
		
		//echo $insert->getSqlString(new \Zend\Db\Adapter\Platform\Mysql());

		$insertState = $this->insertWith($insert);
			
		if($insertState===false){
			throw new \exception('向数据表中添加一条数据失败');
		}
		
		return $insertState;
		
	}//function insertRow() end
	
	
	
	/**
	 * 根据id更新数据库记录
	 * @param int $id || array $id
	 * @throws Exception
	 * @todo 添加对于调用这个方法的验证，检验存在不存在这个字段 并且检查id是不是主键
	 */
	final public function updateRowById($id,$data){
	
		$update = $this->getSql()->update();
	
		$where = new where();
	
		if(is_numeric($id)){
			$where->equalTo('id', $id);
		}
		else if(is_array($id)){
			$where->in('id', $id);
		}
		else{
			throw new \Exception('id参数类型不正确，请不要尝试非法输入');
		}
		
		if(!is_array($data)){
			throw new \Exception('更新数据类型不正确，请不要尝试非法输入');
		}
		
	
		$update->where($where);
		
		$update->set($data);
	
		$updateState = $this->updateWith($update);
	
		if($updateState===false){
			throw new \Exception('更新数据失败，请联系网站管理员');
		}
		
		return $updateState;
	
	}//function deleteRowById() end
	
	/**
	 * 根据传递进来的条件来更新数据
	 * @param int $id || array $id
	 * @throws Exception
	 * @todo 添加对于调用这个方法的验证，检验存在不存在这个字段 并且检查id是不是主键
	 */
	
	final public function updateRowByCondition($where,$data){
		
		$update = $this->getSql()->update();
		
		if(sizeof($where->count())==0){
			throw new \Exception('更新记录的条件为空或不正确，请不要尝试非法输入');
		}
		if(!is_array($data)){
			throw new \Exception('更新数据类型不正确，请不要尝试非法输入');
		}
		
		$update->where($where);
		
		$update->set($data);
		
		$updateState = $this->updateWith($update);
		
		//echo $update->getSqlString(new \Zend\Db\Adapter\Platform\Mysql());
		
		if($updateState===false){
			throw new \Exception('更新数据失败，请联系网站管理员');
		}
		
	}//function updateRowByCondition() end
	
	
	
	
	/**
	 * 根据父子关系重置数据表的左右值
	 * @param int $id
	 * @param int $left_number
	 * @param int $level 
	 * @return number
	 */
	
	final public function rebuildStructureTree($id,$left_number,$level = 0, $restrict = NULL){
	
		
		//如果有传入where条件，对传入的where进行检查
		if ($restrict){
			if (!$restrict instanceof Where){
				throw new \Exception('传入的where条件对象有误');
			}
			
			if ($restrict->count() < 1){
				throw new \Exception('传入的where条件对象是空的');
			}
		}
		
		$right_number = $left_number  + 1;
		//右节点等于左节点加1，在不考虑子节点的情况下
	
		$level = $level+1;
		
		$select = $this->getSql()->select();
	
		$where = new Where();
	
		$where->equalTo('parent_id',$id);
		//这里只查一层节点，只得到子孙的列表
		if ($restrict){
			$where->addPredicate($restrict);//如果有where条件，那么就要把那个带入更新条件
		}
		
		$select->where($where);
	
		$ChildrenList = $this->selectWith($select);
		
	
		foreach($ChildrenList as $Children){
			 
			$right_number = $this->rebuildStructureTree($Children['id'],$right_number,$level,$restrict);
			 
		}//foreach end
	
		//更新数据
		$update = $this->getSql()->update();
	
		$where = new where();
	
		$where->equalTo('id',$id);
	
		if ($restrict){
			$where->addPredicate($restrict);//如果有where条件，那么就要把那个带入更新条件
		}
		$update->where($where);
		
		$update->set(array('left_number'=>$left_number,'right_number'=>$right_number,'level'=>$level));
	
		$this->updateWith($update);
	
		$right_number = $right_number + 1;
	
		return $right_number;
	
	}//function rebuildStructureTree() end
	
	
	/**
     * 根据新插入的节点左值 更新左右值树的所有符合条件的节点的左值和右值
     * 根据删除的节点左值 更新左右值树的所有符合条件的节点的左值和右值
     * @param int $LeftNumber
     * @param string $updateType
     */
	final public function updateLeftNumberAndRightNumber($left_number,$updateType, $where = null){
		
		//如果有传入where条件，对传入的where进行检查
		if ($where){
			if (!$where instanceof Where){
				throw new \Exception('传入的where条件对象有误');
			}
			
			if ($where->count() < 1){
				throw new \Exception('传入的where条件对象是空的');
			}
		}
		
		//第一步：设置左值的更新对象
		$leftNumberUpdate = $this->getSql()->update();
		
		//第二步：新建相关的表达式
		$leftNumberExpression = new Expression();
		
		if($updateType==self::INSERT_NODE){
			$leftNumberExpression->setExpression('`left_number`+2');
		}
		else if($updateType==self::DELETE_NODE){
			$leftNumberExpression->setExpression('`left_number`- 2');
		}
		
		//第三步：设置更新的数据
		$leftNumberUpdate->set(array('left_number'=>$leftNumberExpression));
		
		//第四步：设置更新的条件
		$leftNumberWhere = new Where();
		
		$leftNumberWhere->greaterThan('left_number',$left_number);
		
		if ($where){
			$leftNumberWhere->addPredicate($where);//如果有where条件，那么就要把那个带入更新条件
		}
		
		$leftNumberUpdate->where($leftNumberWhere);
		
		$leftNumberUpdateState = $this->updateWith($leftNumberUpdate);
		
		if($leftNumberUpdateState===false){
			throw new \Exception('更新数据表的左值失败');
		}
		
		
		//第五步：设置右值的更新对象
		$rightNumberUpdate = $this->getSql()->update();
		
		//第六步：新建相关的表达式
		$rightNumberExpression = new Expression();
		
		if($updateType==self::INSERT_NODE){
			$rightNumberExpression->setExpression('`right_number`+2');
		}
		else if($updateType==self::DELETE_NODE){
			$rightNumberExpression->setExpression('`right_number`- 2');
		}
		
		//第七步：设置更新的数据
		$rightNumberUpdate->set(array('right_number'=>$rightNumberExpression));
		
		//第八步：设置更新的条件，注意这里要添加一个等于好
		$rightNumberWhere = new Where();
		$rightNumberWhere->greaterThanOrEqualTo('right_number',$left_number);
		
		if ($where){
			$rightNumberWhere->addPredicate($where);//如果有where条件，那么就要把那个带入更新条件
		}
		
		$rightNumberUpdate->where($rightNumberWhere);
		
		$rightNumberUpdateState = $this->updateWith($rightNumberUpdate);
		
		if($rightNumberUpdateState===false){
			throw new \Exception('更新数据表的右值失败');
		}
		
	}//function updateLeftNumberAndRightNumber() end
	
	
	/**
	 * 根据节点的id得到节点的祖先节点列表
	 * @param int $id
	 * @param boolean $includeSelf
	 * @param int $level;
	 * @return array;
	 * @todo 对于数据表中是否有左右值和层级关系的检查
	 */
	
	final public function getAncestorRowListById($id,$columns=null,$includeSelf = true){
		
		if(!is_numeric($id)){
			throw new \Exception('传入的参数类型错误，不是整型数据');
		}
		
		$row = $this->getRowById($id);
		//得到自身的相关信息
		
		if(sizeof($row)==0){
			return array();
		}
		
		$select = $this->getSql()->select();
		
		if($columns!==null){
			$select->columns($columns);
		}
		
		$where = new where();
		
		if($includeSelf===true){
			
			$where->lessThanOrEqualTo('left_number',$row['left_number']);
			
			$where->greaterThanOrEqualTo('right_number', $row['right_number']);
			
		}
		else if($includeSelf===false){
			
			$where->lessThan('left_number',$row['left_number']);
				
			$where->greaterThan('right_number', $row['right_number']);
			
		}
		
		
		$select->where($where);
		
		$select->order(array('left_number'=>'ASC'));
		
		$result = $this->selectWith($select)->toArray();
		
		return $result;
		
	}//function getAncestorById() end
	
	
	/**
	 * 根据节点的id得到节点的子孙节点列表
	 * @param int $id
	 * @param array $columns
	 * @return array;
	 * @todo 对于数据表中是否有左右值和层级关系的检查
	 */
	
	final public function getDescendantRowListById($id,$columns=null,$includeSelf = true){
		
		if(!is_numeric($id)){
			throw new \Exception('传入的参数类型错误，不是整型数据');
		}
		
		$row = $this->getRowById($id);
		//得到自身的相关信息
		
		if(sizeof($row)==0){
			return array();
		}
		
		$select = $this->getSql()->select();
		
		if($columns!==null){
			$select->columns($columns);
		}
		
		
		$where = new where();
		
		if($includeSelf===true){
			
			$where->greaterThanOrEqualTo('left_number',$row['left_number']);
			
			$where->lessThanOrEqualTo('right_number', $row['right_number']);
			
		}
		else if($includeSelf===false){
			
			$where->greaterThan('left_number',$row['left_number']);
				
			$where->lessThan('right_number', $row['right_number']);
			
		}
		
		$select->where($where);
		
		$result = $this->selectWith($select)->toArray();
		
		return $result;
		
	}//function getDescendantById() end
    
	/**
	 * 根据左右值排序，查询出数据表中具有左右值分类的
	 * @param int $id; 如果设定了这个值，那么查询出来的都是它的子孙节点
	 * @param array $columns
	 * @param int $level $level值是从上往下查询的
	 * @return array || throw Exception
	 * @todo 添加对于调用这个方法的验证，检验存在不存在这个字段 并且检查id是不是主键
	 * @todo 添加对于选取字段的验证，选取的字段是不是都在这个数据表中
	 */
	final public function getUnlimitedRowList($id=null,$columns=null,$level=null,$externalWhere=null,$includeSelf=false){
		
		$where = new where();
		
		$select = $this->getSql()->select();
		
		if(is_numeric($id)){
				
			$info = $this->getRowById($id);
			//根据id查询到信息，这一步的查询是为了查询到节点的左右值

			if(sizeof($info)==0){
				return array();
			}
			else{
				
				if($includeSelf==true){
					//只有当id为数字，且能够查询出结果的时候，查询条件才会被赋值
					$where->greaterThanOrEqualTo('left_number',$info['left_number']);
					
					$where->lessThanOrEqualTo('right_number',$info['right_number']);
				}
				else if($includeSelf==false){
					
					$where->greaterThan('left_number',$info['left_number']);
						
					$where->lessThan('right_number',$info['right_number']);
					
				}//else if end
			
			}
				
		}//如果id是数字的话
		
		if(is_numeric($level)){
			$where->lessThanOrEqualTo('level', $level);
		}
		
		if($externalWhere instanceof Where){
			
			$where->addPredicate($externalWhere,Where::OP_AND);
			
		}//if end
		
		$select->where($where);
		//在这里加载所有的查询条件
		
		if(is_array($columns)){
			$select->columns($columns);
			//在这里加载选取的字段值
		}
		
		$order = array('left_number'=>'asc');
		
		$select->order($order);
		//在这里加载排序的字段
		
		$result = $this->selectWith($select)->toArray();
		
		return $result;
		
	}//function getUnlimitedRowList() end
	
	
	
	/**
	 * 根据数据库中每一行的记录进行筛选
	 * @param array $Attribute
	 * @param array $field
	 * @throws \Exception
	 * @return array
	 * @todo 属性数组中不能包括主键，只能是属性
	 */
	final public function getRowByCondition($condition,$columns = null,$limit = null,$offset = null, $order = null){
	
		$select = $this->getSql()->select();
		//得到select对象
		
		if($columns!==null){
			
			if(is_array($columns)){
				$select->columns($columns);
			}
			else{
				throw new \Exception('字段参数类型不正确，请不要尝试非法输入');
			}
		}
		
		if($condition instanceof Where ){
			
			if($condition->count()==0){
					
				throw new \Exception('查询条件为空不正确，请不要尝试非法输入');
					
			}
			
		}elseif(is_array($condition)){
			
			if(count($condition)==0){
					
				throw new \Exception('查询条件为空不正确，请不要尝试非法输入');
					
			}
		}else{
			
			throw new \Exception('查询条件不正确，请不要尝试非法输入');
		}
			
		$select->where($condition);
			
		if($columns!==null){
				
			if(is_array($columns)){
				$select->columns($columns);
			}
			else{
				throw new \Exception('columns字段参数类型不正确，请不要尝试非法输入');
			}
		}
		
		if($limit!==null){
			if(is_numeric($limit)){
				$select->limit($limit);
			}
			else{
				throw new \Exception('limit字段类型不正确，请不要尝试非法输入');
			}
		}
		
		if($offset!==null){
				
			if(is_numeric($offset)){
				$select->offset($offset);
			}
			else{
				throw new \Exception('offset字段类型不正确，请不要尝试非法输入');
			}
		}
		
		if($order!=null){
			//如果排序被设置了的话，就加载排序
			$select->order($order);
		}
		
		$result = $this->selectWith($select)->toArray();
	
		return $result;
	
	}//function getRowById end
    
    
	
	/**
	 * 根据id返回该节点的所有的子孙节点
	 * @param int $id
	 * @return array
	 */
	public function getChildrenById($id,$restrict = NULL){
		
		//如果有传入where条件，对传入的where进行检查
		if ($restrict){
			if (!$restrict instanceof Where){
				throw new \Exception('传入的where条件对象有误');
			}
				
			if ($restrict->count() < 1){
				throw new \Exception('传入的where条件对象是空的');
			}
		}
		
		//根据角色id得到子孙分类的列表
	
		//根据角色id得到文章分类信息
		$select = $this->getSql()->select();
	
		$where = new where();
	
		$where->equalTo('id',$id);
		
		if ($restrict){
			$where->addPredicate($restrict);//如果有where条件，那么就要把那个带入更新条件
		}
	
		$select->where($where);
	
		$select->columns(array('id','left_number','right_number'));
	
		$roleInfo = $this->selectWith($select)->toArray();
	
		//根据父分类的名称得到子分类的列表
		$parentRoleInfo  = array_pop($roleInfo);
	
		$select = $this->getSql()->select();
	
		$where  = new where();
	
		$where->greaterThan('left_number', $parentRoleInfo['left_number']);
	
		$where->lessThan('right_number', $parentRoleInfo['right_number']);
	
		$select->where($where);
	
		$select->columns(array('id','left_number','right_number'));
	
		$roleChildren = $this->selectWith($select)->toArray();
	
		return $roleChildren;
	
	}//function getChildrenById() end
	
	/**
	 * 根据条件返回在表中存在的条目数量
	 * @param where $where
	 * @return int $num
	 * 
	 */
	public function getCountByCondition($where = null)
	{
		
		$select = $this->getSql()->select();
		
		//如果有传入where条件，对传入的where进行检查
		if ($where != null ){
			if (!$where instanceof Where){
				throw new \Exception('传入的where条件对象有误');
			}
			$select->where($where);
		}
		
		$expression = new Expression();
		$expression->setExpression('count(1)');
		
		$columns = array('num'=>$expression);
		
		$select->columns($columns);
		
		$num = $this->selectWith($select)->toArray();
		
		$num = $num[0]['num'];
		
		return $num;
	}
	
    
}//class BaseModel() end