<?php
namespace Etah\Mvc\Factory\Response;

use Zend\Db\Sql\Where;

use Etah\Mvc\Factory\Response\Response;

/**
 * 公用更新类 checkUpdate
 * @author Edward_sj
 *
 */
class CheckUpdate extends Response
{
	
	public function response()
	{
	
		$request = $this->baseController->getRequest();
			
		//得到服务管理者对象
	
		$config = $this->serviceManager->get('config');
		//得到整个项目合并之后的配置数组
	
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.checkupdate';
		//通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置
	
		if(!isset($config['checkupdate'][$uniqueKey])){
			die('未获取到'.$uniqueKey.'相关的列表配置，请联系网站管理人员！');
		}
	
		$checkUpdateConfig = $config['checkupdate'][$uniqueKey];
	
		//取得数据
		$data = $request->getPost()->toArray();
	
		//前置处理
		$data = $this->preproccess($data, $checkUpdateConfig);
	
		//数据验证
		$dataChecked = $this->validityCheck($data,$checkUpdateConfig);
// 		print_r($dataChecked);
		
		//对于无线分类的数据进行节点合法性验证
		$this->checkSubPoint($checkUpdateConfig, $dataChecked);
	
	
		//文件处理
		$uploadInfo = array();
		$uploadConfig = array();
		$files = null;
	
		if (isset($checkUpdateConfig['file']) && $checkUpdateConfig['file']){
				
			$UniqueKeyUpload = $this->getUniqueKey($this->mvcEvent).'.upload';
			//通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置
// 			print_r($config['upload']);
			if(!isset($config['upload'][$UniqueKeyUpload][$uniqueKey])){
				die('未获取到'.$UniqueKeyUpload.'相关的上传配置，请联系网站管理人员！');
			}
	
			$uploadConfig = $config['upload'][$UniqueKeyUpload][$uniqueKey];
			
			$files = $request->getFiles();
			
			$uploadInfo = $this->preUpload($checkUpdateConfig, $uploadConfig, $dataChecked, $files);
				
		}
		/*
		 * 
		*
		* 1如果主表是无限分类型的， 要先对无限分类进行处理，
		* 修改当前节点的父节点信息，修改其他信息，重新生成树。
		*
		*
		* 2如果主表不是无限分类的，进行普通的数据更新。
		* 更新主表成功后，可以选择触发某个函数，用以移动文件或产生缩略图。
		*
		* 更新副表。更新副表最简单的方法是删除所有原来关于主表的数据，
		* 再把新数据插入表中。
		*
		* 当执行失败时，会回滚数据库。
		* 如果之前除非过移动文件或产生缩略图的函数，则执行删除命令。
		*
		*
		*/
		// 事务操作
		$dbConnection = $this->serviceManager->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction ();
		try {
				
			$retention = $this->updateData($dataChecked,$checkUpdateConfig,$uploadInfo, $uploadConfig);
				
			//回填上传数据
			$uploadInfo = $retention['uploadInfo'];
				
			//文件上传
				
			$this->upload($checkUpdateConfig, $uploadConfig, $retention, $files, 'update');
				
				
		} catch ( \Exception $e ) {
			$dbConnection->rollback ();
			$this->baseController->ajaxReturn ( 300, $e->getMessage () );
		}
	
		$dbConnection->commit ();
	
	
		$this->baseController->ajaxReturn('200', '修改成功',null,'closeCurrent','_blank');
	
	
	
	}
	
	
	private function checkSubPoint($checkUpdateConfig, $dataChecked)
	{
		/*
		 * 检验父节点不是当前节点的子节点
		*
		* 如果类型为无限分类类型，检查选择的parent_id是否是自己的子节点
		*
		*/
		if (isset($checkUpdateConfig['rehabilitation'])){
			 
			foreach ($checkUpdateConfig['rehabilitation'] as $rehabilitation){
				 
				if ($rehabilitation['type'] == 'sort'){
		
				  
					if (!isset($this->baseController->{$rehabilitation['model']})){
						die('model表'.$rehabilitation['model'].'没有被初始化');
					}
		
					$filter_name = $checkUpdateConfig['model'][$rehabilitation['model']]['filter_name'];
		
					if (!isset($dataChecked[$filter_name]['id'])){
						die('编辑错误，指定id解析错误，或没有传入id');
					}
					if (!isset($dataChecked[$filter_name]['parent_id'])){
						die('指定parent_id解析错误，或没有传入parent_id');
					}
		
					$parent_id = $dataChecked[$filter_name]['parent_id'];
		
					if (isset($rehabilitation['restrict'])){
		
						if (!isset($checkUpdateConfig['model'][$rehabilitation['model']]['filter_name'])){
							die($rehabilitation['model'].'的数据找不到');
						}
		
						if (!isset($dataChecked[$filter_name][$rehabilitation['restrict']])){
							die($rehabilitation['restrict'].'的数据在验证后的数据中找不到');
						}
						$right = $dataChecked[$filter_name][$rehabilitation['restrict']];
						$where = new Where();
						$where->equalTo($rehabilitation['restrict'], $right);
		
						$Children = $this->baseController->{$rehabilitation['model']}->getChildrenById($dataChecked[$filter_name]['id'],$where);
		
					}else{
						$Children = $this->baseController->{$rehabilitation['model']}->getChildrenById($dataChecked[$filter_name]['id']);
					}
		
					foreach ($Children as $row){
				   
						if ($row['id'] == $parent_id){
							$this->baseController->ajaxReturn(300, '不能添加到子节点上去');
						}
					}
		
					if ($parent_id == $dataChecked[$filter_name]['id']){
				   
						$this->baseController->ajaxReturn(300, '不能把自己添加到自己的子节点上去');
					}
				  
				}
			}
		}
	}
	
	/**
	 *
	 */
	private function updateData($dataChecked,$checkUpdateConfig, $uploadInfo, $uploadConfig){
		 
		$retention = array();
	
		$modelConfig = $checkUpdateConfig['model'];
	
		foreach ($modelConfig as $model_name=>$model){
	
			if (!isset($this->baseController->{$model_name})){
				die('修改所需要的model'.$model_name.'没有被初始化');
			}
			//初始化
			if (!isset($model['filter_name'])){
				die('请给'.$model_name.'指定取数据的filer');
			}
			 
			if (!isset($dataChecked[$model['filter_name']])){
				die('指定的'.$model['filter_name'].'没有返回数据');
			}
			 
			$updateData = $dataChecked[$model['filter_name']];
			 
			if ($model['type'] == 'masterModel' ){
	
	
				if (!isset($dataChecked[$model['filter_name']]['id'])){
						
					die('指定id解析错误，或没有传入id');
				}
					
				$updateId = $dataChecked[$model['filter_name']]['id'];
	
				$retention['updateId'] = $updateId;
	
				//如果当前操作的是一个主表，可以触发一些特殊的函数
				if (sizeof($uploadConfig) > 0){
	
					foreach ($uploadConfig as $filed=>$config){
							
						if ($config['type'] == 'byflash'){
								
							if (isset($dataChecked[$model['filter_name']][$filed])){
								foreach ($config['columns'] as $key=>$columns){
										
									if (isset($columns['midway'])){
											
										$uploadInfo[$filed.'_'.$key] = $this->baseController->{$columns['midway']}($updateId);
										// 	   									print_r($uploadInfo);
									}
								}
							}
	
						}elseif($config['type'] == 'bypost'){
							$file = $this->baseController->getRequest()->getFiles($filed);
							if (($file['error'] != 0)){
								continue;
							}
						}
					}
				}
	
			}else{
				
				if (isset($dataChecked[$model['filter_name']]['id'])){
					$updateId = $dataChecked[$model['filter_name']]['id'];
				}
				
			}
			 
			//对需要额外处理的数据进行处理
			$additionalData = array();
			 
			if(isset($modelConfig[$model_name]['additional_columns'])){
					
				foreach ($modelConfig[$model_name]['additional_columns'] as $field=>$additional_columns){
					 
					if ($additional_columns['type'] == 'system'){
						 
						$additionalData[$field] = call_user_func($additional_columns['function'],$additional_columns['parameter']);
						 
					}elseif($additional_columns['type'] == 'default') {
						 
						$additionalData[$field] = $additional_columns['value'];
							
					}elseif ($additional_columns['type'] == 'parameter'){
							
						if (!isset(${$additional_columns['parameter']}) || is_null(${$additional_columns['parameter']})){
							die('变量'.$additional_columns['parameter'].'没有被初始化');
						}
						$additionalData[$field] = ${$additional_columns['parameter']};
					}elseif ($additional_columns['type'] == 'upload_info'){
							
						if (isset($additional_columns['map'])){
								
							if (isset($uploadInfo[$additional_columns['map']])){
	
								$info = $uploadInfo[$additional_columns['map']];
								$additionalData[$field] = $info;
	
							}elseif(!isset($additional_columns['allowEmpty']) || $additional_columns['allowEmpty'] == false){
	
								die('文件信息中没有'.$field.'的信息');
							}
								
	
						}
					}elseif ($additional_columns['type'] == 'function'){
							
						$additionalData[$field] = $this->baseController->{$additional_columns['function']}($updateData);
					}
				}
			}
			 
			if (isset($modelConfig[$model_name]['array_columns'])
					&& sizeof($modelConfig[$model_name]['array_columns']) > 0){
					
				foreach ($modelConfig[$model_name]['array_columns'] as $array_columns=>$subcolumns){
					 
					if (!isset($updateData[$array_columns])
							&& sizeof($updateData[$array_columns]) < 1){
						continue;
					}
					//删除跟主表中相关的从表数据
					if (!isset($modelConfig[$model_name]['master_columns'])
							|| sizeof($modelConfig[$model_name]['master_columns']) < 1){
						die($model_name.'的配置文件中master_columns的配置缺失');
					}
	
					$where = new Where();
	
					foreach ($modelConfig[$model_name]['master_columns'] as $field=>$master_columns){
							
						if ($master_columns['type'] == 'parameter'){
							if (!isset(${$master_columns['parameter']})){
								die('变量'.$master_columns['parameter'].'没有被初始化');
							}
	
						}
							
						$where->equalTo($field, ${$master_columns['parameter']});
					}
					if ($where->count()==0){
						die('无法正确取得where条件，master_columns的配置有误');
					}
	
					$this->baseController->{$model_name}->deleteRowByCondition($where);
						
						
						
					foreach ($updateData[$array_columns] as $value){
							
						if (!isset($modelConfig[$model_name]['columns'])){
							die($model_name.'的配置文件中columns缺失');
						}
							
						//对数据进行处理，刨除不需要插入数据库的数据
						$temp = array_intersect_key($updateData, $modelConfig[$model_name]['columns']);
							
						//对数组循环的数据进行数据覆盖
						if (is_array($subcolumns) && sizeof($subcolumns) >0 ){
							 
							if (!is_array($value)){
								die('接受的数据中'.$array_columns.'的值和配置文件不符');
							}
							 
							$temp = array_merge($temp,array_intersect_key($value,$subcolumns));
							 
							unset($temp[$array_columns]);
							 
						}else{
							$temp[$array_columns] = $value;
						}
							
						 
						//把刚才额外处理的数据弄回来
						$temp = array_merge($temp,$additionalData);
	
						if (sizeof($temp) >0 ){
								
							foreach ($modelConfig[$model_name]['master_columns'] as $field=>$master_columns){
									
								if ($master_columns['type'] == 'parameter'){
									if (!isset(${$master_columns['parameter']})){
										die('变量'.$master_columns['parameter'].'没有被初始化');
									}
								}
									
								$temp  = array_merge($temp,array($field=>${$master_columns['parameter']}));
							}
							//添加主表中跟从表相关的数据
							$this->baseController->{$model_name}->insertRow($temp);
						}
					}
					 
				}
					
			}else{
					
					
				if (!isset($modelConfig[$model_name]['columns'])){
					die($model_name.'的配置文件中columns缺失');
				}
					
				//对于某些需要加工的值进行加工
					
				foreach ($modelConfig[$model_name]['columns'] as $key=>$columns){
					 
					if(!isset($columns['type'])){
						continue;
					}elseif ($columns['type'] == 'md5'){
							
						$updateData[$key] = md5($updateData[$key]);
							
					}elseif($columns['type'] == 'map'){
							
						$updateData[$key] = $updateData[$columns['from']];
						//     						unset($updateData[$columns['from']]);
							
					}
				}
				//对数据进行处理，刨除不需要插入数据库的数据，确保不会出错
				$updateData = array_intersect_key($updateData, $modelConfig[$model_name]['columns']);
				 
				//把刚才额外处理的数据弄回来
				$updateData = array_merge($updateData,$additionalData);
					
					
				if(!isset($this->baseController->{$model_name})){
	
					die('添加所需要的数据库对象'.$model_name.'没有完成初始化');
				}
					
				if (sizeof($updateData) >0 ){
// 					    					print_r($updateId);
// 					    					print_r($updateData);
					$this->baseController->{$model_name}->updateRowById($updateId,$updateData);
				}
			}
			 
	
		}
		 
		//数据善后工作
	
		if (isset($checkUpdateConfig['rehabilitation'])){
	
			foreach ($checkUpdateConfig['rehabilitation'] as $rehabilitation){
	
				if ($rehabilitation['type'] == 'sort'){
	
					if(!isset($this->baseController->{$rehabilitation['model']})){
							
						die('编辑所需要的数据库对象'.$rehabilitation['model'].'没有完成初始化');
					}
						
					if (isset($rehabilitation['restrict'])){
							
						if (!isset($checkUpdateConfig['model'][$rehabilitation['model']]['filter_name'])){
							die($rehabilitation['model'].'的数据找不到');
						}
						$filter_name = $checkUpdateConfig['model'][$rehabilitation['model']]['filter_name'];
							
						if (!isset($dataChecked[$filter_name][$rehabilitation['restrict']])){
							die($rehabilitation['restrict'].'的数据在验证后的数据中找不到');
						}
						$right = $dataChecked[$filter_name][$rehabilitation['restrict']];
	
						/*
						 * 由于带入条件后意味着一个表有多个树，那么根节点id就不一定是1,
						* 这样的话就需要求出当前操作节点的根节点id
						*/
						$where = new Where();
						$where->equalTo($rehabilitation['restrict'], $right);
						$where->equalTo('parent_id', 0);
	
						$root = $this->baseController->{$rehabilitation['model']}->getRowByCondition($where);
	
						if (sizeof($root) < 1 ){
							die('当前操作的节点所在的树没有根节点');
						}
	
						if (sizeof($root) > 1 ){
							die('当前操作的节点所在的树有超过一个的根节点');
						}
	
						$root = array_pop($root);
	
						$where = new Where();
						$where->equalTo($rehabilitation['restrict'], $right);
	
						$this->baseController->{$rehabilitation['model']}->rebuildStructureTree($root['id'],$root['left_number'],$root['level']-1,$where);
							
					}else{
						$this->baseController->{$rehabilitation['model']}->rebuildStructureTree(1,1,0);
					}
						
				}
	
			}
	
	
		}
		$retention['uploadInfo'] = $uploadInfo;
	
		return $retention;
		 
	}
	
	
}