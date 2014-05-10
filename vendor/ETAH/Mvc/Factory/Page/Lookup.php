<?php

/**
* 在控制器中显示添加数据库记录的页面
* 函数的目的是为了减少大量的重复的显示列表操作，类似于ShowUserAdd、ShowArticleAdd这样的函数
* 希望能够找出这些列表方法的共性 或者通过参数配置来减少工作量和解放程序员
* 希望可以从每个模块中读取到配置选项，而不是从总体配置文件中读到配置
* 然后根据配置去执行相关的操作
*/

namespace Etah\Mvc\Factory\Page;

use Etah\Mvc\Factory\Page\Read;
use Zend\View\Model\ViewModel;


class Lookup extends Read{

	public function getViewModel(){
		
		$request = $this->baseController->getRequest();
		//得到请求的的对象
		 
		if(!$request->isXmlHttpRequest()){
			die('请不要尝试非法访问，谢谢您的合作！');
		}
		 
		$source = $this->baseController->params('source');
		//得到触发查找带回的源页面
		 
		$name   = $this->baseController->params('name');
		//得到触发查找带回的源页面的字段名称
		 
		$config = $this->serviceManager->get('config');
		//得到整个项目合并之后的配置数组
		 
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.lookup';
		 
		$lookupConfigPath = sprintf("ajax->%s->%s->%s",$uniqueKey,$source,$name);
		 
		//第一步：开始一系列的配置文件的配置型的合法性的判断
		if(!isset($config['ajax'][$uniqueKey][$source][$name])){
			
			die('未获取到'.$lookupConfigPath.'相关的形成查找带回页面的配置，请联系网站管理人员！');
		}
		 
		$lookupConfig = $config['ajax'][$uniqueKey][$source][$name];
		 
		$viewModel = new ViewModel();
		 
		$viewModel->setVariable('source',$source);
		 
		$viewModel->setVariable('formElement',$name);
		 
		//现在意义上的lookup页面实际就是列表页面，如同有无限分类和普通列表页面
		if($lookupConfig['type']=='unlimited'){
		
			$this->checkUnlimitedLookupParameter($lookupConfigPath, $lookupConfig);
			 
			//这个地方是为了接受传递过来的限定参数
			if(isset($lookupConfig['query_condition'])){
		
				$lookupConfig['query_condition'] = $this->getListPageQueryCondition($lookupConfig['query_condition']);
			}
		
			$list = $this->listUnlimitedRowList($lookupConfig);
		
			$postUrl = $this->baseController->{$lookupConfig['post_url']}();
		
			$viewModel->setVariable('pageType','lookup');
		
			$viewModel->setVariable('postUrl',$postUrl);
		
			$appendViewModel = $this->getAppendViewModel($lookupConfig, $list);
			//得到视图对象中追加对象
		
			$appendViewModel->setTemplate('ajax/lookup/list');
		
			$appendViewModel->setVariable('name', $name);
		
			$viewModel->addChild($appendViewModel,'list');
		
			$viewModel->setTemplate('ajax/lookup/unlimited-lookup');
		
		}
		else if($lookupConfig['type']=='filtered'){
		
			$postData = $request->getPost()->toArray();
		
			//这里要添加对于数据的过滤
			$pagerForm = $this->getRowListPagerForm($this->mvcEvent,$lookupConfig,$postData,'lookup');
		
			//过滤列表查询的结果，一个包括数据库记录的列表，一个是符合查询条件的总数
			$result = $this->listFilterRowList($lookupConfig,$postData);
		
			$list      = $result['list'];
		
			$paginator = $result['paginator'];
		
			//向readConfig中设置若干换页的参数，通过readConfig把数据带进页面
			$lookupConfig['count'] 			   = $paginator->getTotalItemCount();
			$lookupConfig['currentPageNumber'] = isset($postData['currentPageNumber'])?$postData['currentPageNumber']:1;
			$lookupConfig['pageRowCount'] 	   = isset($postData['pageRowCount'])?$postData['pageRowCount']:$lookupConfig['pagination']['page_row_count'];
		
			$viewModel->setVariable('list',$list);
			 
			$viewModel->setVariable('templateDisplayColumns',array_keys($lookupConfig['template_display_columns']));
			//得到在模板中显示的字段
			 
			$viewModel->setVariable('selectControlType', $lookupConfig['select_control_type']);
			//得到控件类型
			 
			$paginationForm = $this->getRowListPaginationForm($lookupConfig, $postData,true);
		
			$viewModel->setVariable('pagerForm',$pagerForm);
		
			$viewModel->setVariable('paginationForm', $paginationForm);
		
			$viewModel->setVariable('lookupConfig',$lookupConfig);
		
			$viewModel->setVariable('templateDisplayColumns',$lookupConfig['template_display_columns']);
			 
			$viewModel->setTemplate('ajax/lookup/filtered-lookup');
		}
		
		$viewModel->setVariable('templateDisplayColumns',$lookupConfig['template_display_columns']);
		 
		return $viewModel;
		
	}//function getViewModel() end
	
	private function checkUnlimitedLookupParameter($path,$lookupConfig){
		//因为查找带回的参数太多，而且unlimited 和 filterd两种类型的参数都不太一样，所以分开
		 
		//对于每个条目的选择空间类型的选择
		if(!isset($lookupConfig['select_control_type'])){
			die('未获取到'.$path.'相关的选择控件select_control_type配置，请联系网站管理人员！');
		}
		 
		if(!in_array($lookupConfig['select_control_type'],array('checkbox','radio'))){
			die('选择控件的类型不在允许的范围(checkbox,radio)之内，请联系网站管理人员！');
		}
		 
		if(!isset($lookupConfig['select_type'])){
			die('未获取到'.$path.'相关的选择类型select_type配置，请联系网站管理人员！');
		}
		 
		if(!in_array($lookupConfig['select_type'],array('leaf','both'))){
			die('选择控件的类型不在允许的范围(leaf,all)之内，请联系网站管理人员！');
		}
		 
		if(!isset($lookupConfig['post_url'])){
			die('未获取到'.$path.'相关的获取节点的子分类列表post_url配置，请联系网站管理人员！');
		}
		 
	}//function checkUnlimitedLookupParameter() end
	
	
	
}//class Create() end


?>