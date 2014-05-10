<?php

/**
* 在控制器中显示添加数据库记录的页面
* 函数的目的是为了减少大量的重复的显示列表操作，类似于ShowUserAdd、ShowArticleAdd这样的函数
* 希望能够找出这些列表方法的共性 或者通过参数配置来减少工作量和解放程序员
* 希望可以从每个模块中读取到配置选项，而不是从总体配置文件中读到配置
* 然后根据配置去执行相关的操作
*/

namespace Etah\Mvc\Factory\Page;

use Etah\Mvc\Factory\Page\Page;
use Zend\View\Model\ViewModel;


class view extends Page{

	
	public function getViewModel(){
		
		$config = $this->serviceManager->get('config');
		
		$uniqueKey = $this->getUniqueKey($this->mvcEvent).'.view';
    	//得到唯一的键值
    	
    	$form = $this->getCompletedForm($config,$uniqueKey);
    	//得到经过很多次处理的表单对象
    	
    	$routeMatch = $this->mvcEvent->getRouteMatch();
    	//得到匹配的路由对象

    	$matchedRouteName = $routeMatch->getMatchedRouteName();
    	//得到匹配到的路由的名称
    	 
    	$controller = $routeMatch->getParam('__CONTROLLER__');
    	//得到控制器的名称
    	
    	
    	//添加三个常见的表单元素：submit、reset、close
    	$form->appendFormElement();
    	
    	//为表单添加路由中附加的参数
    	$routeAdditionalParameters = $this->baseController->getRouteAdditionalParameters($routeMatch);
    	
    	foreach($routeAdditionalParameters as $key=>$value){
    		$form->appendFormHiddenElement($key,$value);
    	}
    	
    	$viewModel = new ViewModel();
    	$viewModel->setVariable('form', $form);
    	$viewModel->setTemplate('base/page/create');
    	
    	return $viewModel;
		
	}//function getViewModel() end
	
	
	
	
	
	
	
	
}//class Create() end


?>