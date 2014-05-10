<?php
namespace Etah\Mvc\Factory\Response;

use Zend\Form\Element\File;

use Zend\Db\Sql\Where;

use Etah\Mvc\Factory\Response\Response;

/**
 * 公用添加类 checkCreate
 * @author Edward_sj
 *
 */

class CheckDelete extends Response{
	
	
	
	public function response()
	{
		
		$request = $this->baseController->getRequest();
		 
		//得到服务管理者对象
		
		$config = $this->serviceManager->get('config');
		//得到整个项目合并之后的配置数组
		
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.delete';
		//通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置
		
		if(!isset($config['delete'][$uniqueKey])){
			die('未获取到'.$uniqueKey.'相关的列表配置，请联系网站管理人员！');
		}
		
		$deleteConfig = $config['delete'][$uniqueKey];
		
		//取得数据
		$data = $request->getQuery();
		
		
		//检查id合法性
		if (isset($deleteConfig['master_model']['filter'])){
			$filter = $deleteConfig['master_model']['filter'];
			//字段合法性验证
			$dataChecked = $this->validityCheckForDelete($data,$filter);
		
			$id = $dataChecked['id'];
		}else{
			
			die('检测到删除所需的masterModel配置不正确');
		}
		
		
		//删除前的检测
		if(isset($deleteConfig['check_before_delete'])){
			$this->checkBeforeDelete($id,$deleteConfig);
		}
		
		$dbConnection = $this->serviceManager->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction ();
		//删除开始，开启事务
		
		try {
			//删除
		
			$deleteInfo = $this->checkDelete($id,$deleteConfig);
			 
			//善后处理
			if(isset($deleteConfig['check_after_delete'])){
				$this->checkAfterDelete($deleteInfo,$deleteConfig);
			}
			 
		}catch ( \Exception $e){
		
			$dbConnection->rollback ();
			$this->baseController->ajaxReturn('300', $e->getMessage () );
		}
		 
		$dbConnection->commit ();
		//删除结束关闭事务
		
		$this->baseController->ajaxReturn('200', '删除成功',null,null,'_blank');
		
	}
	
	
	private function validityCheckForDelete($data,$filter)
	{
	
	
		$dataChecked = array();
	
		if(!isset($this->baseController->{$filter['filter_name']})){
			die($filter['filter_name'].'没有被注册');
		}
	
		${$filter['filter_name']} = $this->baseController->{$filter['filter_name']}->getSubInputFilter();
	
		${$filter['filter_name']}->setData($data);
	
		${$filter['filter_name']}->setValidationGroup($filter['filter_field']);
	
		if(${$filter['filter_name']}->isValid()){
			 
			$dataChecked = ${$filter['filter_name']}->getValues();
			 
		}else{
			 
			$dataError = ${$filter['filter_name']}->getMessages ();
	
			foreach ( $dataError as $key => $error ) {
				$this->baseController->ajaxReturn ( '300', array_pop ( $error ) );
			}
			 
		}
	
		return $dataChecked;
	
	}
	/**
	 * 本函数是删除的主体部分，包含主表删除、从表删除和善后处理
	 * @param unknown_type $id
	 * @param unknown_type $deleteConfig
	 */
	
	private function checkDelete($id,$deleteConfig){
	
		//主表删除开始
		if(isset($deleteConfig['master_model']['model'])  ){
			 
			$masterModel = $deleteConfig['master_model']['model'];
			if(!isset($this->baseController->{$masterModel})){
	
				die('删除所需要的数据库对象'.$masterModel.'没有完成初始化');
			}
			$row = $this->baseController->{$masterModel}->getRowById($id);
			$this->baseController->{$masterModel}->deleteRowById($id);
			 
		}else{
			die('配置文件中masterModel配置错误');
		}
		//主表删除结束
		 
		//关系表删除开始
		if(isset($deleteConfig['slave_model'])  && sizeof($deleteConfig['slave_model']) > 0 ){
			foreach ($deleteConfig['slave_model'] as $model=>$slave_delete){
	
				if(!isset($this->baseController->{$model})){
					die('删除所需要的数据库对象'.$model.'没有完成初始化');
				}
				$where = new Where();
				if (isset($slave_delete['map'])){
					
					if (!isset($row[$slave_delete['map']])){
						die('主表信息中不存在'.$slave_delete['map'].'值');
					}
					$where->equalTo($slave_delete['field'], $row[$slave_delete['map']]);
				}else{
					$where->equalTo($slave_delete['field'], $id);
				}
				$this->baseController->{$model}->deleteRowByCondition($where);
	
			}
		}
		//关系表删除结束
		 
		return $row;
		 
	}
	/**
	 * 本函数用于处理删除记录后的善后工作，
	 * 目前的工作就是删除无限分类节点后更新左右值
	 * @param unknown_type $row
	 * @param unknown_type $configs
	 * @param unknown_type $masterModel
	 *
	 */
	
	private function checkAfterDelete($row,$deleteConfig){
		 
		$configs = $deleteConfig['check_after_delete'];
	
		$masterModel = $deleteConfig['master_model']['model'];
		 
		if (sizeof($configs) > 0){
			foreach ($configs as $config){
				if ($config['type'] == 'sort'){
						
					if (isset($config['restrict'])){
							
						$right = $this->baseController->params($config['restrict']);
	
						$where = new Where();
						$where->equalTo($config['restrict'], $right);
						$this->baseController->{$masterModel}->updateLeftNumberAndRightNumber($row['left_number'], 'delete' ,$where);
							
					}else{
						$this->baseController->{$masterModel}->updateLeftNumberAndRightNumber($row['left_number'], 'delete');
					}
						
				}elseif ($config['type'] == 'function'){
	
					$this->baseController->{$config['function']}($row);
	
				}
			}
		}
		 
	}
	
	
	private function checkBeforeDelete($id, $deleteConfig)
	{
		$configs = $deleteConfig['check_before_delete'];
		
		$masterModel = $deleteConfig['master_model']['model'];
		 
		if (sizeof($configs) < 1){
			return ;
		}
		 
		foreach ($configs as $config){
	
			switch ($config['type']){
				 
				case 'sort':{
					if(!isset($this->baseController->{$masterModel})){
						die('删除检测所需要的数据库对象'.$masterModel.'没有完成初始化');
					}
	
					$row = $this->baseController->{$masterModel}->getRowById($id);
	
					if (!isset($row['left_number']) || !isset($row['right_number'])){
							
						die('删除检测中的数据表'.$config['model'].'中不存在left_number或right_number');
					}
	
					if ($row['right_number'] - $row['left_number'] != 1){
							
						$this->baseController->ajaxReturn('300',$config['message']);
					}
	
					break;
	
				}
				case 'status':{
	
					if(!isset($this->baseController->{$master_model})){
						die('删除检测所需要的数据库对象'.$masterModel.'没有完成初始化');
					}
					$row = $this->baseController->{$masterModel}->getRowById($id);
	
					if (!isset($row[$config['field']])){
						die('删除检测所需要的数据表'.$masterModel.'中不存在'.$config['query_field'].'字段');
					}
					if($row[$config['query_field']] == $config['value']){
						$flag = $config['equal'];
					}else{
						$flag = !$config['equal'];
					}
					if (!$flag){
						$this->baseController->ajaxReturn('300',$config['message']);
					}
					break;
				}
				case 'query':{
	
					if(!isset($this->baseController->{$config['model']})){
						die('删除检测所需要的数据库对象'.$config['model'].'没有完成初始化');
					}
	
					$where = new Where();
					$where->equalTo($config['field'], $id);
					$row = $this->baseController->{$config['model']}->getRowByCondition($where);
	
	
					if (sizeof($row) < 1){
						$flag = $config['exist'];
					}else{
						$flag = !$config['exist'];
					}
	
					if (!$flag){
						$this->baseController->ajaxReturn('300',$config['message']);
					}
					break;
				}
				 
				case 'action':{
	
					if(!$this->baseController->{$config['action_name']})
					{
						$this->baseController->ajaxReturn('300',$config['message']);
					}
					break;
				}
				 
				 
			}
	
		}
		 
		 
	}
	
}