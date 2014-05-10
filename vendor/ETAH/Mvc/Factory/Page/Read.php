<?php

/**
* 在控制器中显示数据库中记录的列表
* 函数的目的是为了减少大量的重复的显示列表操作，类似于ShowUserList、ShowArticleList这样的函数
* 希望能够找出这些列表方法的共性 或者通过参数配置来减少工作量和解放程序员
* 如果一个方法有数据权限的访问控制的话，那就不能使用这个方法，需要另外的重新写函数
* 或者是有配置选项，执行ListAction之前需要额外的执行访问控制权限的函数，用来裁切数据
* 希望可以从每个模块中读取到配置选项，而不是从总体配置文件中读到配置
* 然后根据配置去执行相关的操作
*/

namespace Etah\Mvc\Factory\Page;

use Zend\Paginator\Paginator;

use Etah\Mvc\Factory\Page\Page;
use Etah\Mvc\Form\PagerForm;
use Etah\Mvc\Form\PaginationForm;

use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;



class Read extends Page{

	
	public function getViewModel(){
		
		$this->mvcEvent->getRouteMatch();
		 
		$config = $this->serviceManager->get('config');
		//得到整个项目合并之后的配置数组
		 
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.read';
		//通过Mvc事件对象形成 “模块.控制器.方法”的键值，用来查找对应的配置
		 
		$viewModel = new ViewModel();
		 
		if(!isset($config['read'][$uniqueKey])){
			die('未获取到'.$uniqueKey.'相关的列表配置，请联系网站管理人员！');
		}
		 
		$readConfig = $config['read'][$uniqueKey];
		 
		if(!isset($readConfig['template_display_columns'])){
			die('未获取到'.$uniqueKey.'相关的模板列表配置template_display_columns，请联系网站管理人员！');
		}

		$params = $this->baseController->params();
		 
		if($readConfig['type']=='filter'){
		
			$request = $this->baseController->getRequest();
		
			$postData = $request->getPost()->toArray();
		
			//这里要添加对于数据的过滤
			$pagerForm = $this->getRowListPagerForm($this->mvcEvent,$readConfig,$postData);
		
			//过滤列表查询的结果，一个包括数据库记录的列表，一个是翻页类的对象
			$result = $this->listFilterRowList($readConfig,$postData);
		
			$list = $result['list'];//得到数据库的列表页
		
			$paginator = $result['paginator'];//得到翻页对象
		
			//向readConfig中设置若干换页的参数，通过readConfig把数据带进页面
			$readConfig['count']	= $paginator->getTotalItemCount();
			$readConfig['currentPageNumber'] = isset($postData['currentPageNumber'])?$postData['currentPageNumber']:$paginator->getCurrentPageNumber();
			$readConfig['pageRowCount'] 	 = isset($postData['pageRowCount'])?$postData['pageRowCount']:$paginator->getItemCountPerPage();
		
			
			$paginationForm = $this->getRowListPaginationForm($readConfig, $postData);
		
			$viewModel->setVariable('pagerForm',$pagerForm);
		
			$viewModel->setVariable('paginationForm', $paginationForm);
		
			$viewModel->setVariable('readConfig',$readConfig);
		
			$viewModel->setVariable('paginator',$paginator);
			
			$viewModel->setVariable('params',$params);
			
			$viewModel->setTemplate('base/page/filtered-read');
		
			$queryData = array();
		}
		else if($readConfig['type']=='unlimited'){
		
			//这个地方是为了接受传递过来的限定参数
			if(isset($readConfig['query_condition'])){
				 
				$queryData = $this->baseController->getRequest()->getQuery()->toArray();
				 
				$readConfig['query_condition'] = $this->getListPageQueryCondition($readConfig['query_condition'], $queryData);
			}
			else{
				$queryData = array();
			}
		
			$list = $this->listUnlimitedRowList($readConfig);
		
			if(!isset($readConfig['post_url'])){
				die('没有无限分类列表动态的添加子分类设定post_url的取值');
			}
		
			$postUrl = $this->baseController->{$readConfig['post_url']}();
		
			$viewModel->setVariable('postUrl',$postUrl);
			
			$viewModel->setTemplate('base/page/unlimited-read');
		
		}
		 
		if(isset($readConfig['use_assigned_template'])){
			$viewModel->setTemplate($readConfig['use_assigned_template']);
		}
		
		if(isset($readConfig['operation_list'])){
		
			$operationList = $this->getListPageOperationList($readConfig,$queryData);
			 
			$viewModel->setVariable('operationList', $operationList);
		}
		 
		$viewModel->setVariable('templateDisplayColumns',$readConfig['template_display_columns']);
		 
		$viewModel->setVariable('list',$list);
		
		return $viewModel;
		
	}//function getViewModel() end
	
	/**
	 * 得到在普通数据库对象列表的过滤和查询的表单，用以帮助用户查找自己想要得到的数据
	 * 仅限于在类型为filtered的列表使用
	 */
	protected function getRowListPagerForm($mvcEvent,$readConfig,$postData,$dialogType=false){
		 
		//第一步：检查必要的形成过滤表单的必要参数是否已经被设置
		$this->checkPagerFormParameter($readConfig);
		 
		//第二步：设置过滤表单的action属性的属性值
		$pagerForm = new PagerForm();
		 
		$routeMatch = $mvcEvent->getRouteMatch();
		 
		$routeMatchParam = $routeMatch->getParams();
		 
		$routeMatchName  = $routeMatch->getMatchedRouteName();
	
		$controller = $routeMatchParam['__CONTROLLER__'];
		//得到控制器的名称
	
		if($dialogType==false){
			$formAction = $this->url->fromRoute($routeMatchName,array('controller'=>$controller,'action'=>'read'));
		}
		else if($dialogType=='lookup'){
			
			$formAction = $this->url->fromRoute($routeMatchName,
													array(	'controller'=>$controller,
															'action'=>'lookup',
															'source'=>$this->baseController->params('source'),
															'name'=>$this->baseController->params('name'),
												));
	
			$pagerForm->setAttribute('onsubmit',"return dialogSearch(this)");
	
		}
		 
		 
		$pagerForm->setAttribute('action', $formAction);
		 
		//第三步：根据配置文件向过滤表单中添加表单元素
		$formConfig = $readConfig['pager_form'];
		 
		$columns 	= array_keys($formConfig['columns']);
		 
		$pagerForm->completeFormElement($columns,$readConfig);
		 
		//第四步：根据配置文件中顺序重新排序表单中的元素
		$pagerForm->sortFormElement($columns);
		 
		//第五步：为表单中有动态选项值的选择控件填充选项值，就是进行setValueOptions
		//因为有些选项不是固定值，而是从数据库中动态获取的，比如省份列表、学科列表、年级列表、学校类型列表等
		foreach($pagerForm as $element){
			 
			$name =  $element->getName();
			//得到表单对象的name值
			 
			$formElementConfig = $formConfig['columns'][$name];
			 
			if(isset($formElementConfig['options'])){
		
				$options= $formElementConfig['options'];
		
				$model 	  = $options['model'];
		
				$function = $options['function'];
		
				$field	  = $options['field'];
		
				if(!isset($this->baseController->{$model})){
					die('形成添加页面中'.$name.'所需要的数据库对象'.$model.'没有完成初始化');
				}
		
				$valueOptions = $this->baseController->{$model}->{$function}($field);
		
				$valueOptions = $this->baseController->formatValueOptions($valueOptions,$field);
		
				$pagerForm->get($name)->setValueOptions($valueOptions);
			}
		}
		
		//第六步：对于添加字段做处理,在add方法中，现在的需求是回填URL的取值，因为在form使用不了url对象
		if(isset($formConfig['additional_columns'])&&is_array($formConfig['additional_columns'])){
			 
			$additionolColumns = $formConfig['additional_columns'];
			 
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
		
					if(!$pagerForm->has($columnName)){
						die('形成编辑页面的回填数据的目标表单元素'.$columnName.'在表单中不存在');
					}
		
					$pagerForm->get($columnName)->setAttribute($attribute,$urlString);
						
				}
		
			}//foreach end
			 
		}//if end
		
		//第七步：追加常见的表单元素
		$pagerForm->appendFormElement($readConfig);
			
		if($dialogType=='lookup'){
			$pagerForm->appendFormLookupSubmitElement();
		}
		
		//第八步：从表单接受的数据重新回填到新的表单中
		//在这里是原样回填，不涉及任何跟数据库查询发生关系的问题,也不涉及任何id和字符串转换的问题
		foreach($pagerForm as $formElement){
			
			$name  = $formElement->getName();
			
			if(isset($postData[$name]) && $name =='pageRowCount'  ){
				$pagerForm->get($name)->setValue($postData[$name]);
			}
			
			if(isset($postData[$name]) && isset($formConfig['columns'][$name])){
				
				$pagerformElementConfig = $formConfig['columns'][$name];
				
				$fieldValue = $postData[$name];
				
				if(isset($pagerformElementConfig['special_backfill_setting'])){
					
					$specialBackfillSetting = $pagerformElementConfig['special_backfill_setting'];

					$specialBackfillSettingModel = $specialBackfillSetting['model'];
					
					$specialBackfillSettingField = $specialBackfillSetting['query_field'];
					
					$result = $this->baseController->{$specialBackfillSettingModel}->getRowById($fieldValue,$specialBackfillSettingField);
					
					$fieldValue = implode('.', $result);
					
    			}
				
				$pagerForm->get($name)->setValue($fieldValue);
				
			}//if end
		}
		
		return $pagerForm;
		
	}//function getRowListFilterForm() end
	
	/**
	 * 检查形成过滤列表的查询表单所需要的必要参数的方法，目的是把行数较多的函数拆分成小函数
	 *
	 */
	protected function checkPagerFormParameter($readConfig){
		 
		if(!isset($readConfig['pager_form'])){
			die('在形成过滤列表页面的查询表单pagerForm的时候没有找到相关配置');
		}
		 
		if(!isset($readConfig['layout_height'])){
			die('在形成过滤列表页面的查询表单pagerForm的时候没有找到layout_height的相关配置');
		}
		 
		if(!isset($readConfig['pagination']['page_row_count'])){
			die('在形成过滤列表页面的查询表单pagerForm的时候没有找到page_row_count的相关配置');
		}
		 
		if(!isset($readConfig['pager_form']['row_element_count'])){
			die('在形成过滤列表页面的查询表单pagerForm的时候没有找到row_element_count的相关配置');
		}
		 
		 
	}//function checkPagerFormParameter() end
	
	/**
	 * 形成过滤之后的数据库记录列表
	 * @param  array $config
	 * @return array $list
	 */
	protected function listFilterRowList($config,$postData=array()){
		 
		$columns     = array_keys($config['columns']);
		//获取到列表中显示的字段名称
	
		$masterModel = $config['master_model'];
	
		if(!isset($this->baseController->{$masterModel})){
			die('形成列表所需要的数据库对象'.$masterModel.'没有完成初始化');
		}
		 
		$paginationParameter = $this->formatFilteredRowListPaginationParameter($config,$postData);
		 
		$paginator = $this->baseController->{$masterModel}->getFilterRowList($paginationParameter['columns'],$paginationParameter['where'],$paginationParameter['order']);
		 
		$paginator->setItemCountPerPage($paginationParameter['page_row_count']);
		$paginator->setCurrentPageNumber($paginationParameter['current_page_number']);
		$paginator->setPageRange(8);
		
		$list = array();
	
		foreach($paginator as $row){
			array_push($list,$row);
		}
		 
		$result['paginator'] = $paginator;
		 
		$result['list'] = $this->formatRowList($list, $config);
		 
		return $result;
		 
	}//function listFilterRowList() end
	
	
	/**
	 * 针对过滤列表页面的翻页参数进行格式化
	 * 现阶段包括以下几个方面的参数：
	 * 字段列表、偏移量、限制量、
	 *
	 */
	protected function formatFilteredRowListPaginationParameter($config,$postData){
		 
		//第一步：查询字段列表肯定是从配置文件中读取出来的
		$columns = array_keys($config['columns']);
		 
		//第二步：取得查询列表的限制量
		if(!isset($postData['pageRowCount'])){
			$pageRowCount = $config['pagination']['page_row_count'];
		}
		else{
			$pageRowCount = $postData['pageRowCount'];
		}
		 
		//第三步：取得查询列表的偏移量
		if(!isset($postData['currentPageNumber'])){
			$currentPageNumber = 1;
		}
		else{
			$currentPageNumber = $postData['currentPageNumber'];
		}
		
		//取得排序方式
		$order = null;
		
		if(isset($config['order'])){
			$order = $config['order'];
		}
		
		//第四步：设置查询条件
		unset($postData['currentPageNumber']);
		unset($postData['pageRowCount']);
		 
		 
		$columnsSetting 	 = $config['columns'];
		 
		$pagerColumnsSetting = $config['pager_form']['columns'];
		 
		$totalWhere = new where();
		 
		
		foreach($postData as $name=>$value){
	
			if($postData[$name]=='')continue;
	
			$method = $pagerColumnsSetting[$name]['method'];
			
			if( isset($columnsSetting[$name]) && is_array($columnsSetting[$name]) ){
				//如果是数组的话，就需要去其他数据表去查询数据，然后查出来id集合之后再返回回来
				
				$setting = $columnsSetting[$name];
				 
				$queryField  = $setting['result_field'];
				 
				$resultField = $setting['query_field'];
				 
				$model = $this->baseController->{$setting['model']};
				 
				$where = new where();
				 
				switch($method){
					case 'like':$where->like($queryField,'%'.$value.'%');break;
					case 'eq':$where->equalTo($queryField, $value);break;
				}//switch end
				 
				$tempResult = $model->getRowByCondition($where,array( $resultField ) );
				 
				$result = array();
				 
				foreach($tempResult as $row){
					array_push($result,$row[$resultField]);
				}
				 
				if(sizeof($result)>0){
					$totalWhere->in($name,$result);
				}
				else{
					$totalWhere->in($name,array(0));
				}
				 
			}//if end
			else{//如果不是数组的话，就不需要到别的数据库中查询，直接在主表中查询，在这里只需要设置查询条件就好了
			
				if($value===0)continue;
				
				switch($method){
	
					case 'like':$totalWhere->like($name,  '%'.$value.'%');break;
	
					case 'eq':$totalWhere->equalTo($name, $value);break;
	
					case 'gt':$totalWhere->greaterThan($name, $value);break;
	
					case 'egt':$totalWhere->greaterThanOrEqualTo($name, $value);break;
	
					case 'lt':$totalWhere->lessThan($name, $value);break;
	
					case 'elt':$totalWhere->lessThanOrEqualTo($name, $value);break;
	
				}//switch end
				 
			}
	
		}//foreach end

		//var_dump(  $this->baseController->params('type') ); 
		
		//如果设置了通过URL中的链接生成限制条件的内容的话
		if(  isset( $config['params_filter_condition']  )){
			
			$paramsFilterCondition = $config['params_filter_condition'];
			
			foreach($paramsFilterCondition as $paramName=>$anonymousFunction){
				
				$params = $this->baseController->params();
				
				$paramContent = $params($paramName);
				//取得参数所对应的内容
				
				if($paramContent!=NULL){
				//当路由配置中存在该配置的时候
					
					$paramsWhere = $anonymousFunction($params);
					
					if($paramsWhere->count()>0){
						$totalWhere->addPredicate($paramsWhere);
					}
					
				}//if end
				
			}//foreach end
			
		}//路由设置文件中完成根据参数设置条件
		
		//如果设置固定的过滤条件，那么就在where中额外的添加过滤条件
		if(isset($config['filter_constant_condition'])){
	
			$filterConstantCondition = $config['filter_constant_condition'];
	
			foreach($filterConstantCondition as $name=>$condition){
				 
				$method = $condition['method'];
				 
				$value  = $condition['value'];
	
				switch($method){
					 
					case 'like':$totalWhere->like($name,  '%'.$value.'%');break;
					 
					case 'eq':$totalWhere->equalTo($name, $value);break;
	
					case 'neq':$totalWhere->notEqualTo($name, $value);break;
					 
					case 'gt':$totalWhere->greaterThan($name, $value);break;
					 
					case 'egt':$totalWhere->greaterThanOrEqualTo($name, $value);break;
					 
					case 'lt':$totalWhere->lessThan($name, $value);break;
					 
					case 'elt':$totalWhere->lessThanOrEqualTo($name, $value);break;
					
					case 'in':$totalWhere->in($name,$value);break;
					
					case 'notin':$totalWhere->notin($name,$value);break;
					 
				}//switch end
				 
			}//foreach end
	
		}//if end
		 
		
		$parameter = array();
		 
		$parameter['columns'] 				= $columns;
		$parameter['page_row_count'] 		= (int)$pageRowCount;
		$parameter['current_page_number']	= (int)$currentPageNumber;
		$parameter['where']					= $totalWhere;
		$parameter['order']					= $order;
		return $parameter;
		
	}//function formatFilteredRowListPaginationParameter() end
	

	
	protected function getRowListPaginationForm($readConfig,$postData,$dialog=false){
		 
		$paginationForm = new PaginationForm();
		 
		if(isset($readConfig['pagination']['select_value_options'])){
			//如果特别的指定了换页的列表参数，那么就以设置的为准
			$paginationForm->get('pageRowCount')->setValueOptions($readConfig['pagination']['select_value_options']);
		}
		//有的时候，翻页表单是在对话框上打开的，那么这个时候就需要去改变onchange所绑定的事件，要么在对话框上换页效果就不再有效
		if($dialog==true){
			$paginationForm->get('pageRowCount')->setAttribute('onchange',"dialogPageBreak({numPerPage:this.value})");
		}
		
		if(isset($postData['pageRowCount'])){
			//如果换页的时候提交了
			$paginationForm->get('pageRowCount')->setValue($postData['pageRowCount']);
		}
		 
		return $paginationForm;
		
	}//funcition getRowListPaginationForm() end
	
	/**
	 * 根据配置文件生成列表页面上的操作列表问题,比如‘添加视频、删除视频、编辑视频’这样的需求
	 * @param  array $operationList
	 * @return array $operationList
	 * @todo 与RBAC权限控制体系做结合
	 */
	
	protected function getListPageOperationList($readConfig,$queryData){
		 
		$operationList = $readConfig['operation_list'];
		 
		foreach($operationList as $key=>$operation){
			 
			if(!isset($operation['rel'])){
				$operationList[$key]['rel']   = $operation['route'].'.'.implode('.', $operation['route_parameter']);
			}
	
			if(isset($operation['route_addtional_parameter'])){
				 
				$routeAddtionalParameter = $operation['route_addtional_parameter'];
				 
				foreach($routeAddtionalParameter as $innerkey=>$value){
					$operation['route_parameter'][$value] = $queryData[$innerkey];
				}
				 
			}
	
			$operationList[$key]['url']   =  $this->url->fromRoute($operation['route'],$operation['route_parameter']);
			 
			if(isset($operation['param'])){
				$operationList[$key]['url'] = sprintf("%s?%s={%s}",$operationList[$key]['url'],$operation['param'],$operation['param']);
			}
			else{
				$operationList[$key]['url'] = sprintf("%s",$operationList[$key]['url']);
			}
			 
			if(in_array($operation['route_parameter']['action'],array('add','edit','delete','list'))){
				$operationList[$key]['class'] = $operation['route_parameter']['action'];
			}
			else{
				$operationList[$key]['class'] = 'add';
			}
			 
	
		}
	
		return $operationList;
		
	}//function getListPageOperationList() end
	
	/**
	 * 形成没有经过过滤，直接显示的列表,无限分类的列表
	 */
	protected function listUnlimitedRowList($config){
		 
		$columns     = array_keys($config['columns']);
		//获取到列表中显示的字段名称
		 
		$rootId = $config['root_id'];
		//无限分类的根节点的id
	
		$level  = $config['level'];
		//查询无限分类的级别
		 
		//设置查询的条件,这个查询条件是函数之外形成的，函数内不用关心查询条件的形成问题
		if(isset($config['query_condition'])){
			$queryCondition = $config['query_condition'];
		}
		else{
			$queryCondition = array();
		}
		 
		//如果设置固定的过滤条件，那么就在where中额外的添加过滤条件
		if(isset($config['filter_constant_condition'])){
			 
			if(is_array($queryCondition)){
				$queryCondition = new where();
			}
	
	
			$filterConstantCondition = $config['filter_constant_condition'];
			 
			foreach($filterConstantCondition as $name=>$condition){
	
				$method = $condition['method'];
	
				$value  = $condition['value'];
				 
				switch($method){
						
					case 'like':$queryCondition->like($name,  '%'.$value.'%');break;
						
					case 'eq':$queryCondition->equalTo($name, $value);break;
						
					case 'gt':$queryCondition->greaterThan($name, $value);break;
						
					case 'egt':$queryCondition->greaterThanOrEqualTo($name, $value);break;
						
					case 'lt':$queryCondition->lessThan($name, $value);break;
						
					case 'elt':$queryCondition->lessThanOrEqualTo($name, $value);break;
						
				}//switch end
	
			}//foreach end
			 
		}//if end
		 
		 
		$masterModel = $config['master_model'];
		 
		if(!isset($this->baseController->{$masterModel})){
			die('形成列表所需要的主数据库对象'.$masterModel.'没有完成初始化');
		}
		 
		 
		$list = $this->baseController->{$masterModel}->getUnlimitedRowList($rootId,$columns,$level,$queryCondition,false);
	
		$list = $this->formatRowList($list, $config);
		 
		return $list;
		 
	}//function listUnlimitedRowList() end
	
	
	/**
	 * 对查询出来的数据库记录做格式化处理，用来可以在界面上显示
	 * 可能对于以下几个方面做处理
	 * 这个方法被listUnlimitedRowList 和  listFilterRowList 共同调用
	 * 1.把主表中的id性质字段换成从表中的name性质的数据
	 * 2.把一些字段处理成为汉字，比如status处理为 已启用 或 已禁止
	 * 3.把相关字段计算成为显示的数据，比如根据left_number和right_number计算出children_count
	 * @param array $rowList
	 * @param array $config
	 * @return array;
	 */
	
	protected function formatRowList($rowList,$config){
	
		if(sizeof($rowList)==0)return array();
	
		$columnList = $config['columns'];
		//首先得到配置文件中的需要查询的字段的列表
	
		$associativeColumnsList = array();
		//声明一个数组用来承接哪些字段是作为关联查询的字段
	
		$queryArray = array();
		//声明一个数组用来承接关联查询的配置
	
		foreach($columnList as $key=>$column){
	
			//针对于联合查询所做的处理
			if(isset($column['type'])&&$column['type']=='query'){
	
				$column['field'] = $key;
	
				array_push($queryArray,$column);
				//压入关联查询的配置数组
	
				array_push($associativeColumnsList,$key);
				//压入关联查询的字段
	
			}//if end
	
		}//foreach end
	
		foreach($associativeColumnsList as $column){
	
			$column = $column."_list";
			//然后在后面添加一个'_list'后缀，用来承接数组
	
			${$column} = array();
			//这句话相关于 声明了一个 video_sort_id_list的数组，用来承接id列表
		}//foreach end
	
		foreach($rowList as $outer_key=>$row){
	
			foreach($row as $key=>$value){
				if(in_array($key,$associativeColumnsList)){
					array_push( ${$key.'_list'}  ,$value);
				}
			}
		}//foreach end
	
	
		foreach($queryArray as $key=>$query){
	
			$QueryField   = array(  $query['query_field'], $query['result_field']  );
			//得到要到其他的数据表要查询的字段
	
			$QueryIdList =   array_unique(  ${$query['field']."_list"}  ) ;
			//得到上面收集得到的id的列表
	
			if(!isset($this->baseController->{$query['model']})){
				die('形成列表所需要的'.$query['model'].'辅助数据库对象没有完成初始化');
			}
			
			$where = new Where();
			$where->in($query['query_field'],$QueryIdList);
			//根据配置填写的键值来查找结果
	
			$result = $this->baseController->{$query['model']}->getRowByCondition( $where,$QueryField);
			//查询得到结果
	
			${$query['field'].'_result'} = array();
	
			foreach($result as $value){
	
				$key   = $value[  $query['query_field']  ];
	
				$value = $value[  $query['result_field'] ];
	
				${$query['field'].'_result'}[$key] = $value;
			}
	
		}
	
		//print_r($config['additional_columns']);
		//print_r($rowList);
	
		foreach($rowList as $outer_key=>$row){
	
			foreach($row as $key=>$value){
	
				if(in_array($key,$associativeColumnsList)){
	
					$additonalKey = $key."_string";
					//额外的新加的数值,比如键名叫做video_sort_id，那么现在的additionalKey就叫做video_sort_id_string
	
					if(isset(   ${$key.'_result'}[$value]  )){
						$rowList[$outer_key][$additonalKey] = ${$key.'_result'}[$value];
					}
					else{
						$rowList[$outer_key][$additonalKey] = '';
					}
	
				}//if end
	
			}
	
			if(isset($config['additional_columns'])&&is_array($config['additional_columns'])){
				//只有在有额外的字段需要判定的时候才有下面的操作
	
				$additionalColumns = $config['additional_columns'];
	
				foreach($additionalColumns as $additionalKey=>$additionalValue){
	
					$rowList[$outer_key][$additionalKey] = $this->baseController->{$additionalValue}($row);
	
				}
	
			}//if end
	
		}//foreach end
	
		return $rowList;
	}//function formatRowList() end
	
	
	/**
	 * 为BaseController中几个方法提供视图对象
	 *
	 * 包括list列表中unlimitdedList、lookup类型中unlimitdedList以及这两种方法中一定会调用的append方法
	 *
	 * 实际上是这三个方法所对应的模板中都有公共的循环数据库对象的模板内容，就是append模板的内容
	 *
	 * @param array $config 配置文件对象
	 * @param array $list   数据库记录列表对象
	 * @return viewModel
	 */
	protected function getAppendViewModel($config,$list){
			
		$viewModel = new ViewModel();
			
		$viewModel->setVariable('list',$list);
			
		$viewModel->setVariable('templateDisplayColumns',array_keys($config['template_display_columns']));
		//得到在模板中显示的字段
			
		//以下这两个选项目前只在pageType为lookup的时候起效
		$viewModel->setVariable('selectControlType', $config['select_control_type']);
		//得到控件类型
			
		$viewModel->setVariable('selectType', $config['select_type']);
		//得到选择类型
		$viewModel->setTemplate('ajax/append/append');
			
		return $viewModel;
			
	}//function getAppendViewModel() end
	
	
	
	
	
	
	
	
	
	
}//class Create() end


?>