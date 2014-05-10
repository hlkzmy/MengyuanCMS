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


class Append extends Read{

	public function getViewModel(){
		
		$request = $this->baseController->getRequest();
		 
		if(!$request->isXmlHttpRequest()){
			die('请不要尝试非法操作!');
		}
		 
		$postData = $request->getPost()->toArray();
		//从提交的表单中获取到数据
		 
		$id = $postData['id'];
		//得到节点的id
		 
		if(isset($postData['page_type'])){
		
			$pageType = $postData['page_type'];
			//得到触发这个方法的列表类型，是普通的read页面还是控件之上打开的查找带回页面lookup
		
			$source = $postData['source'];
			//得到最先触发这个方法的源方法
			 
			$formElement = $postData['form_element'];
			//得到触发这个方法的表单元素
		
		}
		else{
		
			$pageType = 'read';
		
		}
		 
		$config = $this->serviceManager->get('config');
		//得到整个项目合并之后的配置数组
		 
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.'.$pageType;
		 
		 
		if( $pageType == 'lookup' ){
		
			if(!isset($config['ajax'][$uniqueKey][$source][$formElement])){
				 
				die(sprintf('在动态获取子节点的时未获得ajax->%s->%s->%s相应的列表文件配置',$uniqueKey,$source,$formElement));
		
			}
		
			$readConfig	= $config['ajax'][$uniqueKey][$source][$formElement];
		
		}
		else if( $pageType == 'read' ){
		
			if(!isset($config['read'][$uniqueKey])){
				 
				die('在动态获取子节点的时未获得相应的'.$uniqueKey.'列表文件配置');
		
			}
		
			$readConfig	= $config['read'][$uniqueKey];
		}
		 
		 
		$parentRowField = array('id','name','level');
		 
		$masterModel = $readConfig['master_model'];
		 
		if(!isset( $this->baseController->{$masterModel} )){
			die('在动态获取子节点的时,相应的数据库对象'.$masterModel.'没有被初始化！');
		}
		 
		$parentRow = $this->baseController->{$masterModel}->getRowById($id,$parentRowField);
		 
		$targetRowLevel = (int)$parentRow['level'] + 1;
		 
		$rowField = array_keys( $readConfig['columns'] );
		 
		$rowList   = $this->baseController->{$masterModel}->getUnlimitedRowList($id,$rowField,$targetRowLevel,null,false);
		//取得在数据库层面上经过处理的地域列表 formatRowList
		 
		$rowList  = $this->formatRowList($rowList,$readConfig);
		//得到格式化之后的行列表
		 
		$viewModel = $this->getAppendViewModel($readConfig, $rowList);
		 
		if(isset($formElement)){
			$viewModel->setVariable('name', $formElement);
		}
		 
		return $viewModel;
		
	}//function getViewModel() end
	
	
	
	
	
	
	
	
	
	
	
}//class Create() end


?>