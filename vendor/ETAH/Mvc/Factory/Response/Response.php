<?php
namespace Etah\Mvc\Factory\Response;

use Zend\Validator\File\Extension;
use Zend\Validator\File\Size;
use Zend\InputFilter\FileInput;

/**
 * 作为响应函数的基类，例如 checkcreate，checkupdate
 * @author Edward_sj
 *
 */

class Response{
	
	protected $config;
	
	protected $url;
	
	protected $serviceManager;
	
	protected $baseController;
	
	
	public function setBaseController($baseController){
		$this->baseController = $baseController;
		return $this;
	}
	
	public function setServiceManager($serviceManager){
		$this->serviceManager = $serviceManager;
		return $this;
	}
	
	public function setConfig($config){
		$this->config = $config;
		return $this;
	}//function setConfig
	
	public function setUrl($url){
		$this->url = $url;
		return $this;
	}//function setConfig
	
	public function setMvcEvent($mvcEvent){
		$this->mvcEvent = $mvcEvent;
		return $this;
	}
	
	protected function getUniqueKey($event){
		 
		$routeMatchParam = $event->getRouteMatch()->getParams();
	
		$module 	= strtolower(substr($routeMatchParam['__NAMESPACE__'], 0,strpos($routeMatchParam['__NAMESPACE__'], '\\')));
		//得到模块的名称
		 
		$controller = $routeMatchParam['__CONTROLLER__'];
		//得到控制器的名称
		 
		$key = strtolower( $module.".".$controller );
		 
		return $key;
		 
	}//function getUniqueKey() end

	
	/**
	 * 数据预处理
	 * @param unknown_type $data
	 * @param unknown_type $config
	 * @return unknown
	 */
	
	protected function preproccess($data, $config)
	{
		
		if (isset($config['preproccess'])){
		
			if (isset($config['preproccess']['postdata']) && sizeof($config['preproccess']['postdata']) >0){
					
				foreach ($config['preproccess']['postdata'] as $function){
					$data = $this->baseController->{$function}($data);
				}
				 
			}
		
			if (isset($config['preproccess']['check']) && sizeof($config['preproccess']['check']) >0){
					
				foreach ($config['preproccess']['check'] as $function){
					$this->baseController->{$function}();
				}
				 
			}
		}
		
		
		return $data;
		
	}
	
	protected  function validityCheck($postdata,$config)
	{
		$filterConfig = $config['filter'];
		//获取对filter的所有相关配置
		 
		$dataChecked = array();
		//初始化准备放置返回值的数组
	
		//开始检查表
		foreach ($filterConfig as $filterName=>$filter){
	
			$columns = isset($filter['columns'])?$filter['columns']:array();
			//数据表过滤的字段，这种类型是一个字段一个数值，而不是数组的
			
			$array_columns = isset($filter['array_columns'])?$filter['array_columns']:array();
			//数据表过滤的字段，这种类型是一个字段一个数组，收上来的数据是数组类型
			
			$dataChecked[$filterName] = array();
	
	
			if (sizeof($columns) > 0 ){
				 
				//对某些需要处理的值进行处理
				foreach ($columns as $key=>$column){
	
					if (isset($column['allowEmpty']) && $column['allowEmpty']== true){
						if (empty($postdata[$key])){
							unset($columns[$key]);
							continue;
						}
	
					}
					if(!isset($column['type'])){
							
						continue;
							
					}elseif ($column['type'] == 'md5'){
	
						$postdata[$key] = md5($postdata[$key]);
	
					}elseif($column['type'] == 'map'){
							
						$postdata[$key] = $postdata[$column['from']];
					
	
					}else{
						continue;
					}
	
				}
				
				$dataChecked[$filterName] =  $this->checkData($postdata, $filterName, array_keys($columns));
			
				
			}//if (sizeof($columns) > 0 ) end
			if( sizeof($array_columns) >0 ){
				
				foreach ($array_columns as $field=>$subcolumns){
					if (!isset($postdata[$field])  || sizeof($postdata[$field]) < 1){
						continue;
					}
					
					if (!is_array($postdata[$field])){
						
						//如果发现传进来的不是数组,那就试图用','分隔的方式去解析他。
						$postdata[$field] = explode(',',$postdata[$field]);
						if (!is_array($postdata[$field])){
							
							//解析完了发现还不是能够用的数组，那就没办法了
							
							die($field.'参数既不是数组，也不是用\',\'分隔的字符串');
							
						}
						
					}
					$dataChecked[$filterName][$field] = array();
	
					foreach ($postdata[$field] as $data){
						 
						if (is_array($subcolumns) && sizeof($subcolumns) >0 ){
	
							if (!is_array($data)){
								die('接受的数据中'.$field.'的值和配置文件不符');
							}
							${$field}[$field] = $this->checkData($data, $filterName, array_keys($subcolumns));
	
							$dataChecked[$filterName] = array_merge_recursive($dataChecked[$filterName],${$field});
								
						}
						else{
	
							${$field} = $this->checkData(array($field=>$data), $filterName, array($field));
								
							$dataChecked[$filterName] = array_merge_recursive($dataChecked[$filterName],${$field});
						
						}//else end
	
						 
					}//foreach ($postdata[$field] as $data) end
	
				}//foreach ($array_columns as $field=>$subcolumns) end
		   
			}
	
		}
		return $dataChecked;
	}
	/**
	 * 数据验证的从方法
	 * @param unknown_type $postdata
	 * @param unknown_type $filter
	 * @param unknown_type $columns
	 */
	
	private function checkData($postdata,$filter,$columns){
	
		if(!isset($this->baseController->{$filter})){
			die('添加数据验证所需的'.$filter.'没有被注册');
		}
		
		
		if(method_exists ($this->baseController->{$filter},'setAdapter')){
			$dbAdapter = $this->serviceManager->get('Zend\Db\Adapter\Adapter');
			$this->baseController->{$filter}->setAdapter($dbAdapter);
		}
		
		${$filter} = $this->baseController->{$filter}->getSubInputFilter();
		
		//从控制器中拿到过滤对象
	
		${$filter}->setData($postdata);
	
		${$filter}->setValidationGroup($columns);
	
		if(${$filter}->isValid()){
			 
			return ${$filter}->getValues();
			 
		}
		else{
			 
			$dataError = ${$filter}->getMessages ();
			
			foreach ( $dataError as $key => $error ) {
				$this->baseController->ajaxReturn ( '300', array_pop ( $error )  );
			}//foreach end
			 
		}//else end
		
	}//function checkData() end
	
	
	
	
	
	/**
	 * 大文件预上传
	 * 验证文件合法性并上传文件
	 */
	protected function preUpload($config, $uploadConfig, $dataChecked, $files)
	{
		$uploadInfo = array();
		 
		if (isset($config['file']) && $config['file']){
		
			
			foreach ($uploadConfig as $filed=>$uconfig){
				 
				foreach ($config['model'] as $model){
					if ($model['type'] == 'masterModel'){
						$masterFilter = $model['filter_name'];
					}
				}
				
				if (!isset($masterFilter)){
					die('masterModel没有指定filter_name');
				}
					
				if ($uconfig['type'] == 'byflash'){
					
					if (!isset($dataChecked[$masterFilter][$filed])){
						
						if (isset($uconfig['allowEmpty']) && $uconfig['allowEmpty'] == true){
							continue;
						}
						die('没有获取到'.$filed.'的相关信息');
					}
					
					$DiskDirectory = TEMP_DISK_PATH.$dataChecked[$masterFilter][$filed];
					$uploadInfo[$filed.'_source'] = $DiskDirectory;
		
					foreach ($uconfig['columns'] as $key=>$columns){
						if (isset($columns['prepose'])){
							$uploadInfo[$filed.'_'.$key] = $this->baseController->{$columns['prepose']}($uploadInfo[$filed.'_source']);
						}
					}
		
				}elseif($uconfig['type'] == 'bypost'){

					if (!isset($files[$filed])  || $files[$filed]['error'] !=0 ){
						if (isset($uconfig['allowEmpty']) && $uconfig['allowEmpty'] == true ){
							continue;
						}
						$this->baseController->ajaxReturn ( '300', '没有检测到要上传的文件，请检查您的页面'  );
					}
					
					$file = $files[$filed];
					foreach ($uconfig['columns'] as $key=>$columns){
						if (isset($columns['prepose'])){
							$uploadInfo[$filed.'_'.$key] = $this->baseController->{$columns['prepose']}($file);
						}
					}
		
		
				}
				
				if (isset($uconfig['subdir']) && isset($dataChecked[$masterFilter][$uconfig['subdir']])){
					$uploadInfo[$uconfig['subdir']] = $dataChecked[$masterFilter][$uconfig['subdir']];
				}
				
				
			}
		
		}
		return $uploadInfo;
		
	}
	
	protected function upload($checkCreateConfig, $uploadConfig, $retention, $files, $type)
	{
		
		if (isset($checkCreateConfig['file']) && $checkCreateConfig['file']){
			 
			if (!isset($uploadConfig)){
				die('没有检测到本页面关于上传的配置文件');
			}

			$uploadInfo = $retention['uploadInfo'];
			
			foreach ($uploadConfig as $filed=>$config){
					
				if ($config['type'] == 'byflash'){
					
					
					if (!isset($uploadInfo[$filed.'_source'])){
					
						if (isset($config['allowEmpty']) && $config['allowEmpty'] == true){
							continue;
						}
					}
						
					$source = $uploadInfo[$filed.'_source'];
					
					if (!is_file($source)){
						
						die('文件路径'.$source.'不正确,请检查文件路径');
					}
					
		
					if (!isset($config['subdir'])){
		
						$subdir = ($type =='update')?$retention['updateId']:$retention['lastInsertValue'].'/';
		
					}elseif( $config['subdir'] !== false ){
						
						if (!isset($uploadInfo[$config['subdir']])){
							die('上传文件过程中，提交数据中没有`'.$config['subdir'].'`的相关数据，请检查设置和数据');
						}
		
						$subdir = $uploadInfo[$config['subdir']].'/';
		
					}else{
						$subdir = null;
					}
						
						
					$target = $config['target'].$subdir.$uploadInfo[$filed.'_'.$config['filename']];
					$data = $this->MoveUploaded($source, $target);
		
					if (!$data['status']){
						throw new \Exception($data['info']);
					}
						
					foreach ($config['columns'] as $key=>$columns){
						if (isset($columns['postposition'])){
							$this->baseController->{$columns['postposition']}($source,$target);
						}
					}
					//转码
					if (isset($config['translate'])){
						$id = ($type =='update')?$retention['updateId']:$retention['lastInsertValue'];
						$this->baseController->{$config['translate']['function']}($source,$target,$id);
						
					}
					 
				}elseif($config['type'] == 'bypost'){
						
					$file = $files[$filed];
					
					if (!isset($files[$filed]) || $files[$filed]['error'] !=0){
						if (isset($config['allowEmpty']) && $config['allowEmpty'] == true ){
							continue;
						}
						die('没有检测到文件流，请检查配置名称是否正确');
					}
						
					//对post的文件进行检验
					$fileInput = new FileInput();
					$fileInput->setName($filed);
					$fileInput->setValue($file);
					$fileInput->setAllowEmpty(true);
					
					if (isset($config['Validator']['ext'])){
		
						$ext = new Extension($config['Validator']['ext']);
						$ext->setMessage('只能上传后缀名为'.implode(',', $config['Validator']['ext']).' 的文件');
						$fileInput->getValidatorChain()->addValidator($ext);
		
					}
						
					if (isset($config['Validator']['size'])){
							
						$size = new Size();
						$size->setMax($config['Validator']['size']);
						$size->setMessage('只允许'.$config['Validator']['size'].'以下的文件上传');
						$fileInput->getValidatorChain()->addValidator($size);
							
					}
						
					if (!$fileInput->isValid()){
		
						foreach ( $fileInput->getMessages() as $key => $error ) {
							$this->baseController->ajaxReturn ( '300', $error );
						}
					}
						
					$source = $file['tmp_name'];
						
					if (!isset($config['subdir'])){
		
						$subdir = ($type =='update')?$retention['updateId']:$retention['lastInsertValue'].'/';
		
					}elseif( $config['subdir'] !== false ){
		
						if (!isset($uploadInfo[$config['subdir']])){
							die('上传文件过程中，提交数据中没有`'.$config['subdir'].'`的相关数据，请检查设置和数据');
						}
		
						$subdir = $uploadInfo[$config['subdir']].'/';
		
		
					}else{
						$subdir = null;
					}
						
					$target = $config['target'].$subdir.$uploadInfo[$filed.'_'.$config['filename']];
					$data = $this->MoveUploaded($source, $target);
		
					if (!$data['status']){
						throw new \Exception($data['info']);
					}
						
					foreach ($config['columns'] as $key=>$columns){
						if (isset($columns['postposition'])){
							$this->baseController->{$columns['postposition']}($source,$target);
						}
					}
						
						
				}else{
						
					throw new \Exception('不合法的文件上传形式');
				}
			}
		}
	}
	
	
	/**
	 * 本方法用于把上传成功的文件从临时目录移动到存储路径
	 * @param $source  临时文件目录
	 * @param $target  目标文件目录
	 * @return multitype:number string
	 */
	protected  function MoveUploaded($source, $target){
	
	
		if(!is_dir(dirname($target))){//如果视频存放的磁盘目录不存在的话，就创建她
			$this->createDirectory(dirname($target));
		}else{
	
			if(file_exists($target)){//如果磁盘目录里面有同名文件了，就删除他
				unlink($target);
			}
	
		}
	
	
		if(rename( $source ,  $target )){
	
			$array = array(
					'status'=>1,
					'info'=>'在上传过程中，把文件从临时文件夹移动到存储目录成功',
					'data'=>$target
			);
	
		}
		else{
	
			$array = array(
					'status'=>0,
					'info'=>'在上传过程中，把文件从临时文件夹移动到存储目录失败',
			);
		}
	
	
		return $array;
	
	}//function MoveUploadVideo() end
	
	/**
	 * 递归方式创建文件夹
	 * @param unknown_type $path
	 * @throws \Exception
	 */
	private static function createDirectory($path){
		//循环创建文件夹，保证路径传递进来一定有文件夹形成
	
		if (!file_exists($path)){
	
			self::createDirectory(dirname($path));
	
			if (!mkdir($path, 0777)){
				throw new \Exception('目录不能被正确创建');
	
			}
	
		}
	
	}//function createDirectory() end
	
	
}