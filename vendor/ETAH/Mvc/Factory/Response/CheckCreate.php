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

class CheckCreate extends Response{
	
	
	public function response(){
	
		$request = $this->baseController->getRequest();
		 
		//得到服务管理者对象
		$config = $this->serviceManager->get('config');
		//得到整个项目合并之后的配置数组
		
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.checkcreate';
		//通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置
		
		if(!isset($config['checkcreate'][$uniqueKey])){
			die('未获取到'.$uniqueKey.'相关的列表配置，请联系网站管理人员！');
		}
		
		$checkCreateConfig = $config['checkcreate'][$uniqueKey];
		
		//取得数据
		$data = $request->getPost()->toArray();
		
		//前置处理
		$data = $this->preproccess($data, $checkCreateConfig);
		
		//print_r($data);
		
		//数据验证
		$dataChecked = $this->validityCheck($data,$checkCreateConfig);
		
		//文件处理
		$uploadInfo = array();
		$uploadConfig = array();
		$files = null;
		
		if (isset($checkCreateConfig['file']) && $checkCreateConfig['file']){
				
			$UniqueKeyUpload = $this->getUniqueKey($this->mvcEvent).'.upload';
			//通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置
				
			if(!isset($config['upload'][$UniqueKeyUpload][$uniqueKey])){
				die('未获取到'.$UniqueKeyUpload.'相关的上传配置，请联系网站管理人员！');
			}
	
			$uploadConfig = $config['upload'][$UniqueKeyUpload][$uniqueKey];
			
			$files = $request->getFiles()->toArray();
			$uploadInfo = $this->preUpload($checkCreateConfig, $uploadConfig, $dataChecked, $files);
				
		}

		// 事务操作
		$dbConnection = $this->serviceManager->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction ();
		try {			
			
			//1.插入数据, 缝合伤口，数据善后处理
			$retention = $this->insertData($dataChecked, $checkCreateConfig, $uploadInfo, $uploadConfig);
			
			//回填上传数据
			$uploadInfo = $retention['uploadInfo'];
			
			//文件上传
			$this->upload($checkCreateConfig, $uploadConfig, $retention, $files,  'create');
			
			
		} catch ( \Exception $e ) {
    		$dbConnection->rollback ();
    		$this->baseController->ajaxReturn ( 300, $e->getMessage () );
    	}
    	 
    	$dbConnection->commit ();
    	 
    	$this->baseController->ajaxReturn('200', '添加成功',null,'closeCurrent','_blank');
		
	}
	
	private function insertData($dataChecked, $checkCreateConfig, $uploadInfo = array() , $uploadConfig = array() )
	{
		$retention = array();
		 
		$modelConfig = $checkCreateConfig['model'];
	
		$lastInsertValue = null;
		foreach ($modelConfig as $model_name=>$model){
			 
			 
			if (!isset($this->baseController->{$model_name})){
				die('添加所需要的数据库对象'.$model_name.'没有被初始化');
			}
			//初始化
			if (!isset($dataChecked[$model['filter_name']])){
				die('请给'.$model_name.'指定取数据的filter');
			}
			$insertData = $dataChecked[$model['filter_name']];
			$additionalData = array();
	
			//对需要额外处理的数据进行处理
			if(isset($modelConfig[$model_name]['additional_columns'])){
					
				foreach ($modelConfig[$model_name]['additional_columns'] as $field=>$additional_columns){
	
					if ($additional_columns['type'] == 'system'){
	
						$additionalData[$field] = call_user_func($additional_columns['function'],$additional_columns['parameter']);
	
					}elseif($additional_columns['type'] == 'default') {
	
						$additionalData[$field] = $additional_columns['value'];
							
					}elseif ($additional_columns['type'] == 'parameter'){
							
						if (!isset(${$additional_columns['parameter']}) || is_null(${$additional_columns['parameter']})){
							die('变量'.$additional_columns['parameter'].'没有被初始化,请检查配置文件中model部分主表是否写在前面');
						}
							
						$additionalData[$field] = ${$additional_columns['parameter']};
							
					}elseif ($additional_columns['type'] == 'upload_info'){
							
						if (isset($additional_columns['map'])){
	
							$info = $uploadInfo[$additional_columns['map']];
	
						}else{
							$info = $uploadInfo[$field];
						}
							
						if (!isset($info)){
							die('文件信息中没有'.$field.'的信息');
						}
							
						$additionalData[$field] = $info;
							
					}elseif ($additional_columns['type'] == 'function'){
	
						$additionalData[$field] = $this->baseController->{$additional_columns['function']}($insertData);
					}
				}
			}
			if (isset($modelConfig[$model_name]['array_columns'])
					&& sizeof($modelConfig[$model_name]['array_columns']) > 0){
					
				foreach ($modelConfig[$model_name]['array_columns'] as $array_columns=>$subcolumns){
	
					if (!isset($insertData[$array_columns])
							|| sizeof($insertData[$array_columns]) < 1){
						continue;
					}
	
					foreach ($insertData[$array_columns] as $value){
							
						if (!isset($modelConfig[$model_name]['columns'])){
							die($model_name.'的配置文件中columns缺失');
						}
							
						//对数据进行处理，刨除不需要插入数据库的数据
						$temp = array_intersect_key($insertData, $modelConfig[$model_name]['columns']);
		    	
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
		    	
		    	
						//对需要额外处理的master_columns数据进行处理
						if(isset($modelConfig[$model_name]['master_columns'])){
								
							foreach ($modelConfig[$model_name]['master_columns'] as $field=>$additional_columns){
									
								if ($additional_columns['type'] == 'system'){
										
									$master_columns[$field] = call_user_func($additional_columns['function'],$additional_columns['parameter']);
										
								}elseif($additional_columns['type'] == 'default') {
										
									$master_columns[$field] = $additional_columns['value'];
										
								}elseif ($additional_columns['type'] == 'parameter'){
										
									if (!isset(${$additional_columns['parameter']}) || is_null(${$additional_columns['parameter']})){
										die('变量'.$additional_columns['parameter'].'没有被初始化,请检查配置文件中model部分主表是否写在前面');
									}
										
									$master_columns[$field] = ${$additional_columns['parameter']};
										
								}
							}
		    		
							if (sizeof($master_columns) < 1){
								die('无法正确读取到master_columns的内容');
							}
		    		
						}else{
							die('没有检测到master_columns的配置');
						}
	
						//把刚才额外处理的数据弄回来
						$temp = array_merge($temp,$additionalData);
		    	
						$temp = array_merge($temp,$master_columns);
		    	
						if (sizeof($temp) >0 ){
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
					}
					if ($columns['type'] == 'md5'){
							
						$insertData[$key] = md5($insertData[$key]);
							
					}elseif($columns['type'] == 'map'){
							
						$insertData[$key] = $insertData[$columns['from']];
						//    							unset($insertData[$columns['from']]);
							
					}else{
						continue;
					}
				}
				//对数据进行处理，刨除不需要插入数据库的数据，确保不会出错
				$insertData = array_intersect_key($insertData, $modelConfig[$model_name]['columns']);
	
				//把刚才额外处理的数据弄回来
				$insertData = array_merge($insertData,$additionalData);
					
					
				if(!isset($this->baseController->{$model_name})){
						
					die('添加所需要的数据库对象'.$model_name.'没有完成初始化');
				}
					
				if (sizeof($insertData) >0 ){
					//     						print_r($insertData);
					$this->baseController->{$model_name}->insertRow($insertData);
						
					$retention = array_merge($retention,$insertData);
				}
			}
	
			if ($model['type'] == 'masterModel' ){
	
				$lastInsertValue = $this->baseController->{$model_name}->LastInsertValue;
	
				if (isset($insertData['id'])){
					$lastInsertValue = $insertData['id'];
				}
				$retention['lastInsertValue'] = $lastInsertValue;
	
				if (sizeof($uploadConfig) > 0){
	
					foreach ($uploadConfig as $filed=>$config){
		   		
						if ($config['type'] == 'byflash'){
								
							foreach ($config['columns'] as $key=>$columns){
								if (isset($columns['midway'])){
										
									$uploadInfo[$filed.'_'.$key] = $this->baseController->{$columns['midway']}($lastInsertValue);
									// 	   									print_r($uploadInfo);
								}
							}
								
						}elseif($config['type'] == 'bypost'){
								
							// @todo bypost
								
						}
					}
				}
			}
		}
		 
		//数据善后工作
	
		if (isset($checkCreateConfig['rehabilitation'])){
			 
			foreach ($checkCreateConfig['rehabilitation'] as $rehabilitation){
	
				if ($rehabilitation['type'] == 'sort'){
						
					if(!isset($this->baseController->{$rehabilitation['model']})){
							
						die('添加所需要的数据库对象'.$rehabilitation['model'].'没有完成初始化');
					}
						
					$lastInsertData = $this->baseController->{$rehabilitation['model']}->getRowById($lastInsertValue);
						
					if ($lastInsertData['parent_id'] == 0){
						//如果是根节点，添加的时候特殊对待
						$update = array(
								'left_number'=>1,
								'right_number'=>2,
								'level'=>1
						);
	
					}else{
						$parent = $this->baseController->{$rehabilitation['model']}->getRowById($lastInsertData['parent_id']);
							
						$left_number = $parent['right_number'];
							
						$right_number = $left_number+1;
							
						$level = $parent['level']+1;
							
						$update = array(
								'left_number'=>$left_number,
								'right_number'=>$right_number,
								'level'=>$level
						);
						if (isset($rehabilitation['restrict'])){
	
							if (!isset($checkCreateConfig['model'][$rehabilitation['model']]['filter_name'])){
								die($rehabilitation['model'].'的数据找不到');
							}
							$filter_name = $checkCreateConfig['model'][$rehabilitation['model']]['filter_name'];
	
							if (!isset($dataChecked[$filter_name][$rehabilitation['restrict']])){
								die($rehabilitation['restrict'].'的数据在验证后的数据中找不到');
							}
							$right = $dataChecked[$filter_name][$rehabilitation['restrict']];
							$where = new Where();
							$where->equalTo($rehabilitation['restrict'], $right);
	
							$this->baseController->{$rehabilitation['model']}->updateLeftNumberAndRightNumber($parent['right_number'],'insert',$where);
	
						}else{
							$this->baseController->{$rehabilitation['model']}->updateLeftNumberAndRightNumber($parent['right_number'],'insert');
						}
					}
					$this->baseController->{$rehabilitation['model']}->updateRowById($lastInsertValue,$update);
				
				}elseif($rehabilitation['type'] == 'function'){
					
					
					$this->baseController->{$rehabilitation['function']}($retention);
					
					
				}
	
			}
			 
			 
		}
		$retention['uploadInfo'] = $uploadInfo;
	
		return $retention;
	
		 
	}
	
}