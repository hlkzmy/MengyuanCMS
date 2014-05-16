<?php

namespace Cms\Component\Slide\Javascript;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;
use Cms\Component\Slide\Javascript\SlideElement;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $imageBasePath = 'theme/default/common/slide';//图片的基准路径
	
	protected $showNavigation = false;//是否显示幻灯片下面的导航栏
	
	protected $showShadow = false;//显示幻灯片下面的阴影
	
	
	public $slideElementList = array();
	
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	public function setShowNaviagtion($status){
		$this->setVariable('showNavigation', $status);
		return $this;
	}
	
	public function setShowShadow($status){
		$this->setVariable('showShadow', $status);
		return $this;
	}
	
	
	
	
	/**
	 * 
	 * @param string $path
	 * @return \Cms\Component\Slide\Javascript\Content
	 */
	public function setImageBasePath($path){
		$this->imageBasePath = $path;
		return $this;
	}
	
	
	/**
	 * 向幻灯片组件中添加幻灯片的图片的元素
	 * 幻灯片是一个组件,里面每一张图片是一个元素
	 * @param int $id
	 * @param string $path
	 * @param string $title
	 * @param string $description
	 */
	public function addSlideElement($id,$title,$description,$path,$href=null){
		
		$element = new SlideElement();
		$element->setId($id)
				->setImagePath($path)
				->setTitle($title)
				->setDescription($description);
		
		if(is_null($href)){
			$element->setHref('javascript:;');
		}
		
		$this->slideElementList[$id] = $element;//如果有相同id的元素就会进行覆盖
		return $this;
	}//function addSlideElement() end
	
	
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//1. 得到基础路径的视图助手，从而得到完整的http绝对路径
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		
		//2.得到phpRenderer对象，从而附加css js
		$phpRenderer = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$phpRenderer->headLink()	->appendStylesheet($basePathViewHelper('component/slide/javascript/css/style.css'));
		$phpRenderer->headScript()	->appendFile($basePathViewHelper('component/slide/javascript/js/jquery.easing.1.3.js'))
									->appendFile($basePathViewHelper('component/slide/javascript/js/jquery.scrollTo-min.js'));
									//->appendFile($basePathViewHelper('component/slide/javascript/js/aktuals.js'));
		
		
		//3.将对象中的幻灯片组件远足添加到模版中用于循环
		foreach($this->slideElementList as $key=>$element){
			$path = $basePathViewHelper(sprintf("%s/%s",$this->imageBasePath,$element->imagePath));
			$this->slideElementList[$key]->setImagePath($path);
		}
		
		
		
		$this->setVariable('slideElementList', $this->slideElementList);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



