<?php

/**
     * 在控制器中显示编辑数据库记录的页面
     * 函数的目的是为了减少大量的重复的显示列表操作，类似于ShowUserEdit、ShowArticleEdit这样的函数
     * 希望能够找出这些列表方法的共性 或者通过参数配置来减少工作量和解放程序员
     * 希望可以从每个模块中读取到配置选项，而不是从总体配置文件中读到配置
     * 然后根据配置去执行相关的操作
     */

namespace Etah\Mvc\Factory\Page;

use Etah\Mvc\Factory\Page\Page;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;

class Update extends Page{

	
	public function getViewModel(){
		
		$request = $this->baseController->getRequest();
		 
		if(!$request->isXmlHttpRequest()){
			die('请不要尝试非法操作访问页面,谢谢您的合作');
		}
		 
		$queryData = $request->getQuery()->toArray();
		 
		$id = $queryData['id'];
		 
		$config = $this->serviceManager->get('config');
		//得到配置数组
		
		//得到经过很多次处理的添加对象的表单对象
		//这个表单对象是从add配置数组生成的
		//需要进行字段的裁切，因为有些字段一旦填了之后，就不允许编辑了，比如身份证号码
		//需要进行字段值的回填，编辑是要把原来添加的时候提供的数据都回填回来，让用户编辑之后再提交
		$uniqueKey = $this->getUniqueKey($this->mvcEvent);
		 
		$uniqueAddKey = $uniqueKey.'.create';
		 
		if(!isset($config['create'][$uniqueAddKey])){
			die('未获取到'.$uniqueAddKey.'相关的添加页面配置，请联系网站管理人员！');
		}
		 
		$form = $this->getCompletedForm($config,$uniqueAddKey);
		 
		$uniqueUpdateKey = $uniqueKey.'.update';
		 
		if(!isset($config['update'][$uniqueUpdateKey])){
			die('未获取到'.$uniqueUpdateKey.'相关的编辑页面配置，请联系网站管理人员！');
		}
		 
		$updateConfig = $config['update'][$uniqueUpdateKey];
		//取得取得添加页面的相关操作
		 
		//----------------------------以下为在添加表单上做处理形成编辑表单的相关操作--------------------------------//
		 
		//第一步：裁切字段，如果一个字段添加之后不能再编辑的话，就从表单中移除
		if(!isset($updateConfig['columns'])){
			die('未获取到'.$uniqueKey.'字段列表的相关配置columns，请联系网站管理人员！');
		}
		 
		$columns = $updateConfig['columns'];
		 
		foreach($form as $element){
		
			$name = $element->getName();
		
			if(!in_array($name,$columns)){
				$form->remove($name);
			}
		
		}//foreach end
		 
		//第二步：填充数据，读取配置文件，查询数据库，然后回填数据
		if(!isset($updateConfig['data'])){
			die('未获取到'.$uniqueKey.'数据来源的相关配置data，请联系网站管理人员！');
		}
		 
		if(isset($updateConfig['additional_columns'])){
			//查询有没有需要额外赋值的字段，现阶段只有查找带回字段需要额外的设置
			$additionalColumns =  array_keys($updateConfig['additional_columns']);
			$additionalColumnsConfig = $updateConfig['additional_columns'];
		}
		 
		$dataConfig = $updateConfig['data'];
		 
		foreach($dataConfig as $model=>$field){
		
			if(!isset($this->baseController->{$model})){
				die('形成编辑页面中所需要的数据库对象'.$model.'没有完成初始化');
			}
		
			$modelConfig = $dataConfig[$model];
		
			$modelType 	 = $modelConfig['type'];
		
			if($modelType == 'master'){
				 
				$field = $modelConfig['field'];
				 
				$result = $this->baseController->{$model}->getRowById($id,$field);
				 
				foreach($result as $key=>$value){
		
					if(isset($additionalColumns)){
						//如果设置了额外需要处理的字段
		
						if(in_array($key,$additionalColumns)){
							//并且当前字段在额外处理字段的列表中
							$this->handleEditFormAdditionalColumns($key,$value,$additionalColumnsConfig[$key],$form);
		
							continue;
						}
					}//if(isset($additionalColumns)) end
		
					${$key} = $form->get($key);
					if (!isset(${$key})){
						die('没有'.$key.'相关的值,请检查配置是否正确(不要把键值写成数组了！！)');
					}
					
					${$key}->setValue($value);
				}
			}
			else if($modelType=='slave'){
				 
				$conditionField =  $modelConfig['condition_field'];
				//得到辅助表中条件查询字段
				 
				$queryField 	=  $modelConfig['query_field'] ;
				//得到辅助表中字段选取字段
				 
				if(isset($additionalColumns)){
					//如果设置了额外需要处理的字段
					 
					if(in_array($queryField,$additionalColumns)){
						continue;
					}
		
				}
				 
				$where = new Where();
				//新建查询对象
				 
				$where->equalTo($conditionField,$id);
				 
				$queryResult = $this->baseController->{$model}->getRowByCondition($where,array( $queryField ));
				 
				$result = array();
				 
				if(sizeof($queryResult)==0)continue;
				 
				foreach($queryResult as $value){
					array_push($result,$value[$queryField]);
				}
		
				if(!$form->has($queryField)){
					die('形成编辑页面的回填数据的目标表单元素'.$queryField.'在表单中不存在');
				}
				 
				$form->get($queryField)->setValue($result);
				 
			}
			else{
				die('形成编辑页面中所需要的数据库对象'.$model.'类型设置错误');
			}
		
		}//循环dataConfig的配置型
		 
		$routeMatch = $this->mvcEvent->getRouteMatch();
		//得到匹配的路由对象
		 
		$matchedRouteName = $routeMatch->getMatchedRouteName();
		//得到匹配到的路由的名称
		 
		$controller = $routeMatch->getParam('__CONTROLLER__');
		//得到控制器的名称
		
		$formAction = $this->url->fromRoute($matchedRouteName,array('controller'=>$controller,'action'=>'checkUpdate'));
		//得到form的action属性
		
		$form->setAttribute('action',$formAction);
		//设置form的action属性，避免在无数模板上都设置一次action属性
		 
		//添加三个常见的表单元素：submit、reset、close
		$form->appendFormElement();
		 
		//为表单添加路由中附加的参数
		$routeAdditionalParameters = $this->baseController->getRouteAdditionalParameters($routeMatch);
		
		foreach($routeAdditionalParameters as $key=>$value){
			$form->appendFormHiddenElement($key,$value);
		}
		 
		//在编辑界面上添加隐藏域，一般意义上为当前对象的id
		$form->appendFormHiddenElement('id',$id);
		 
		$viewModel = new ViewModel();
		$viewModel->setVariable('form', $form);
		
		
		if(isset($updateConfig['use_assigned_template'])){
			$viewModel->setTemplate($updateConfig['use_assigned_template']);
		}
		else{
			$viewModel->setTemplate('base/page/update');
		}		
		
		return $viewModel;
		
	}//function getViewModel() end
	
	
	
	
	
	
	
	
}//class Create() end


?>