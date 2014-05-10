<?php
/**
 * 得到成员变量的取值，然后返回成员变量的
 * @author hlkzmy
 *
 */

namespace Etah\Mvc\Factory\Page;

use Etah\Mvc\Form\BaseForm;
//加载数组操作的类，用以编辑表单的时候回填数值
use Etah\Common\ArrayOperation\Travel as ArrayTravel;

use Zend\Db\Sql\Where;

abstract class Page{

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
     * 一般意义上 【添加界面】 和 【编辑界面】要共用一个Form
     * 而编辑界面完全可以读取添加界面的配置来形成页面
     * 编辑界面只是在后面需要填空数值而已
     * 那么不希望添加界面 和编辑界面都需要去配置冗长的数组
     * 把添加界面  和 编辑界面的形成页面的公共部分提出来，就是getCompletedForm的作用
     */
    protected  function getCompletedForm($config,$uniqueKey){
    
    	if(!isset($config['create'][$uniqueKey])){
    		die('未获取到'.$uniqueKey.'相关的添加配置，请联系网站管理人员！');
    	}
    
    	$createConfig = $config['create'][$uniqueKey];
    	//取得取得添加页面的相关操作
    
    	$formName = lcfirst($createConfig['form']);
    	//去配置文件中取得表单的名称
    	 
    	if(!isset($this->baseController->{$formName})){
    		//进行条件判断
    		$form = new BaseForm();
    	}
    	else{
    		$form = $this->baseController->{$formName};
    	}
    
    	
    	//取得表单对象，赋值给一个变量，
    
    	$columns = array_keys($createConfig['columns']);
    	//得到字段列表
    
    	//根据配置文件对表单元素进行处理，最终保持表单元素与配置文件的一致
    	$form->completeFormElement($columns,$createConfig);
    
    	//循环每个字段,对于字段中的配置存在option选项字段进行数据库查询服务
    	foreach($form as $element){
    		 
    		$name =  $element->getName();
    		//得到表单对象的name值
    		
    		$formElementConfig = $createConfig['columns'][$name];
    		 
    		if(isset($formElementConfig['options'])){
    
    			$options= $formElementConfig['options'];
    
    			$model 	  = $options['model'];
    
    			$function = $options['function'];
    
    			$field	  = $options['field'];
    			
    			$defaultValue = isset($options['defaultValue'])?$options['defaultValue']:true;
    			
    			if(!isset($this->baseController->{$model})){
    				die('形成添加页面中'.$name.'所需要的数据库对象'.$model.'没有完成初始化');
    			}
    
    			
    			$valueOptions = $this->baseController->{$model}->{$function}($field);
    
    			$valueOptions = $this->baseController->formatValueOptions($valueOptions,$field,$defaultValue);
    
    			$form->get($name)->setValueOptions($valueOptions);
    		}
    	}
    
    	//因为前面在不断的添加元素和减去元素,所以在最后按照配置文件中顺序重新排一次表单的顺序
    	$form->sortFormElement($columns);
    
    	//对于添加字段做处理,在add方法中，现在的需求是回填URL的取值，因为在form使用不了url对象
    	if(isset($createConfig['additional_columns'])&&is_array($createConfig['additional_columns'])){
    		 
    		$additionolColumns = $createConfig['additional_columns'];
    		 
    		foreach($additionolColumns as $columnName=>$columnConfigArray){
    			//循环额外处理的字段列表
    			 
    			foreach($columnConfigArray as $attribute=>$attributeSetting){
    				 
    				if(!isset($attributeSetting['function'])){
    						
    					$message = sprintf('需要额外处理的%s字段的%s属性没有指定方法',$columnName,$attribute);
    						
    					die($message);
    				}
    
    				$function = $attributeSetting['function'];
    
    				if(isset($attributeSetting['parameter'])){
    						
    					$parameter = $attributeSetting['parameter'];
    						
    					$parameter_value =  $this->baseController->params($parameter);
    						
    					$urlString = $this->baseController->{$function}($parameter_value);
    
    				}
    				else{
    						
    					$urlString = $this->baseController->{$function}();
    						
    				}
    
    				if(!$form->has($columnName)){
    					die('形成编辑页面的回填数据的目标表单元素'.$columnName.'在表单中不存在');
    				}
    
    
    				$form->get($columnName)->setAttribute($attribute,$urlString);
    					
    			}
    
    		}//foreach end
    		 
    	}//if end
    	 
		return $form;
    
    }//function getCompletedForm() end
    
    
    
    /**
     * 根据配置文件和GET的数据形成查询条件条件
     */
    protected function getListPageQueryCondition($conditionSetting,$data=null){
    	 
    	$where = new Where();
    	 
    	foreach($conditionSetting as $key=>$setting){
    
    		$type   = $setting['type'];
    
    		$method = $setting['method'];
    		 
    		$field  = $setting['field'];
    
    		if($type=='param'){
    			$value  = $this->baseController->params($field);
    		}
    		else if($type=='query'){
    			$value  = $data[$field];
    		}
    		else if($type=='custom'){
    			$value = $field;
    		}
    
    		switch($method){
    
    			case 'like':$where->like($key,  '%'.$value.'%');break;
    
    			case 'eq':$where->equalTo($key, $value);break;
    
    			case 'gt':$where->greaterThan($key, $value);break;
    
    			case 'egt':$where->greaterThanOrEqualTo($key, $value);break;
    
    			case 'lt':$where->lessThan($key, $value);break;
    
    			case 'elt':$where->lessThanOrEqualTo($key, $value);break;
    
    		}//switch end
    
    	}//foreach end
    	 
    	return $where;
    }//function getListPageQueryCondition() end
    
    
    
    /**
     * 处理编辑表单的额外添加的字段，主要完成对一些复杂的表单对象的赋值问题
     * 现阶段处理两种问题：
     * 1.对于查找带回组件进行额外的一次数据库查询，把id对应的中文名称查询出来，然后把id赋值到隐藏域中，把中文名称赋值到显示域，对应的配置文件的类型为field_lookup,意思为字段查找带回
     * 2.对于从数据库中查询的某些字段进行反序列化操作，比如CSS的序列化属性，然后把属性设置到表单的每一个元素上面去，对应的配置文件的类型为field_unserialize，意思为字段反序列化
     * @param string $fieldName  字段名称，从表单循环中获取
     * @param string $fieldValue 字段名称，所对应的字段的取值
     * @param array  $fieldConfig 字段所对应的配置数组
     * @param form   $form 当前的表单对象
     */
    
    protected function handleEditFormAdditionalColumns($fieldName,$fieldValue,$fieldConfig,$form){
    	 
    	if(!isset($fieldConfig['type'])){
    		die('没有设置编辑表单的额外添加的字段的处理类型type的取值');
    	}
    	 
    	$type = $fieldConfig['type'];
    	 
    	if($type=='field_unserialize'){
    		// 如果是字段反序列化操作的话
    
    		$unserializeArray = unserialize($fieldValue);
    
    		if(!$unserializeArray){
    			return;
    		}
    
    		$pathInfoList = array();
    
    		ArrayTravel::depthFirst($unserializeArray, $pathInfoList);
    
    		foreach($pathInfoList as $pathInfo){
    			 
    			$pathArray  = explode( '-' , $pathInfo['path'] );
    			//得到路径数组，因为在做深度遍历的时候，是用中划线做的分隔符
    			 
    			$formElementName = $fieldName.'['.implode('][',$pathArray).']';
    			//计算出表单元素的路径
    			 
    			if($form->has($formElementName)){
    				$form->get($formElementName)->setValue(  $pathInfo['value']  );
    			}
    		}
    
    	}
    	else if($type=='field_json_decode'){
    		// 如果是字段反序列化操作的话
    		 
    		$jsonDecodeArray = json_decode($fieldValue);
    		 
    		if(!$jsonDecodeArray){
    			return;
    		}
    		 
    		$pathInfoList = array();
    		 
    		ArrayTravel::depthFirst($jsonDecodeArray, $pathInfoList);
    		 
    		foreach($pathInfoList as $pathInfo){
    
    			$pathArray  = explode( '-' , $pathInfo['path'] );
    			//得到路径数组，因为在做深度遍历的时候，是用中划线做的分隔符
    
    			$formElementName = $fieldName.'['.implode('][',$pathArray).']';
    			//计算出表单元素的路径
    
    			if($form->has($formElementName)){
    				$form->get($formElementName)->setValue(  $pathInfo['value']  );
    			}
    		}
    		 
    	}
    	else if($type=='field_lookup'){
    		//如果是字段查找带回的话
    		 
    		$additionalModel 		=  $fieldConfig['model'];
    
    		$additionalField 		=  $fieldConfig['query_field'] ;
    
    		$additionalResult = $this->baseController->{$additionalModel}->getRowById($fieldValue,$additionalField);
    
    		if(sizeof($additionalResult)==0){
    			//如果没有查询到对应的信息的时候，就可能是根节点的父节点为0，然后查询不到相关信息的时候
    			 
    		}
    		else{
    			$handleResult = implode('.', $additionalResult);
    			$form->get($fieldName)->setValue($handleResult);
    		}
    
    	}
    	 
    }//function formatEditFormAdditionalColumns() end
    
   
    
	
	
	
	
	
}//class Create() end


?>