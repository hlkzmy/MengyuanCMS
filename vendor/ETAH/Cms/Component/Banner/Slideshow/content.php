<?php

namespace Etah\Cms\Component\Banner\Slideshow;

use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Where;


class Content{
	
	private $serviceManager = null;
	
	function __construct($serviceManager){
		
		$this->serviceManager = $serviceManager;
		
	}
	
	/**
	 * 通过解析内容配置文件 来获取模板中需要的各种数据
	 * 把这部分解析的内容从前台中分离出来，最大的好处就是不需要在网站前台中适应各种内容组件的数据查询方法，
	 * 因为根本不可能适应各种各样的内容组件的方法，那样的话解析配置文件的时候是需要复杂到什么程度的switch 或者  if
	 * 这样的话也很难让第三方的用户进来编辑内容组件，因为每做一个内容组件，都需要在网站前台中解析页面的时候添加一种情况
	 * 
	 * 为了解决以上的问题：
	 * 1.网站前台调用的时候，通过数据库的路径拼接得到内容组件的形成内容的php文件，统一命名为content.php ,文件中的类的名称为  class content{}
	 * 
	 * 2.网站后台调用的时候，通过数据库的路径拼接得到内容组件的形成配置界面的php文件，统一命名为config.php,文件中的类的名称为 class config{}
	 * 
	 * 3.形成配置界面的php文件通过类似于生成添加对象的界面返回给后台的都是一个post的数组，只不过 create界面需要有参数解析然后选择进行各种操作的checkCreate
	 *   配置界面形成的POST数组只需要被序列化，然后存进数据库，然后在形成页面的时候可以被自己解析出来就可以
	 *   
	 * 4.整个过程实际上就是内容组件自己配置自己，自己解析自己的过程，系统完全不参与，系统只负责在合适的时候新建一下内容组件的对象，然后调一下统一对象就可以了
	 * 
	 * 5.内容组件实际上就是提供给用户选择数据来源，存放数据来源，解析数据来源，渲染组件模板，它不停被系统所调用，把形成的字符串返回系统，然后参与构成页面的过程
	 * 
	 * @param object $controller
	 * @param object $contentConfig
	 * @return array data
	 */
	
	private function getDataByParseContentConfig($controller,$contentConfig){
		
		$contentConfig  = unserialize($contentConfig);
		
		//第一步：检验参数
		$this->checkContentConfigParameter($controller,$contentConfig);
		
		//第二步：解析内容,每个内容组件这部分都不一样
		$limit   = $contentConfig['limit'];
		
		$bannerType = $contentConfig['bannerType'];
		
		$where = new where();
		
		$where->equalTo('download_status','finished');
		
		$where->equalTo('status','Y');
		
		$where->equalTo('translate_status','Y');
		
		$columns = $contentConfig['columns'];
		
		$limit   = $contentConfig['limit'];
		
		if ($bannerType == 'new'){
			
			$order = array('add_time'=>'desc');
			
		}elseif ($bannerType == 'hot'){
			$order = array('pv'=>'desc');
		}
		
		$videoList = $controller->videoModel->getRowByCondition($where,$columns,$limit,0,$order);
		
		$basePath = dirname(dirname($controller->getRequest()->getBasePath()));
		
		//3.方便模板做出的一些改动，主要是形成冗长的URL
		foreach($videoList as $key=>$video){

			$filename = sprintf("%s%s/%s_640x480.jpg",VIDEO_DISK_DIRECTORY,$video['id'],$video['thumb']);
			
			if (!file_exists($filename)) {
				$videoList[$key]['img_src']   = sprintf("%s/%s/%s/%s",$basePath,'media/video','default','big.png');
			}else{
				$videoList[$key]['img_src']   = sprintf("%s/%s/%s/%s_640x480.jpg",$basePath,'media/video',$video['id'],$video['thumb']);
			}
			$videoList[$key]['title_url'] = $controller->url()->fromRoute('resource',array('controller'=>'video','action'=>'play','id'=>$video['id']));
				
			$videoList[$key]['img_url']   = $videoList[$key]['title_url'];
		}
		
		//4.填装数据
		
		$data['list'] 			 = $videoList;
		return $data;
		
	}//function formatData() end
	
	
	/**
	 * 用来检验内容组件的内容参数是否符合要求
	 */
	
	private function checkContentConfigParameter($controller,$contentConfig){
		
		$modelList = array('videoModel');
		
		foreach($modelList as $model){
			
			if(!isset($controller->{$model})){
				die(  sprintf('形成内容组件所需要的数据表%s在当前调用内容组件的控制器没有完成初始化',$model));
			}
		
		}
		
		
	}//function checkContentConfig() end
	
	
	public function render($controller,$contentConfig){
		
		$data = $this->getDataByParseContentConfig($controller,$contentConfig);
		
		$basePath = $controller->getRequest()->getBasePath();
		$PhpRenderer = $this->serviceManager->get ( 'Zend\View\Renderer\PhpRenderer' );
		$PhpRenderer->headLink()->appendStylesheet($basePath.'/theme/website/common/Cms/Banner/Slideshow/new_video_js.css');
		$PhpRenderer->headLink()->appendStylesheet($basePath.'/theme/website/common/Cms/Banner/Slideshow/new_video.css');
		$PhpRenderer->headScript()->appendFile($basePath.'/theme/website/common/Cms/Banner/Slideshow/new_video.js');
		
		$viewModel = new ViewModel();
		
		$viewModel->setTemplate('component/Banner/Slideshow/template');
		
		$viewModel->setVariable('data', $data);
		
		$html = $PhpRenderer->render($viewModel);
		
		return $html;
	}//function renderTemplate() end
	
	
	
	
	
	
	
}//class Common end