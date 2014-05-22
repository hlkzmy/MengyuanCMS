<?php

namespace Cms\Component\FriendLink;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;
use Cms\Component\FriendLink\ChildrenElement;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $imageBasePath = 'theme/default/common/friend-link';//图片的基准路径
	
	protected $childrenElementType = null;
	
	protected $childrenElementList = array();
	
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	
	/**
	 * 设置子元素的类型
	 * @param unknown $type
	 * @return \Cms\Component\FriendLink\Content
	 */
	
	public function setChildrenElementType($type){
		$this->childrenElementType = $type;
		return $this;	
	}
	
	
	/**
	 * 
	 * @param string $path
	 * @return \Cms\Component\Slide\Javascript\Content
	 */
	public function setImageBasePath($path){
		
		if($this->childrenElementType!='image'){
			die('友情链接组件的子元素类型不是图片类型');
		}
		
		$this->imageBasePath = $path;
		return $this;
	}
	
	
	/**
	 * 像友情链接那样添加
	 * 幻灯片是一个组件,里面每一张图片是一个元素
	 * @param int $id
	 * @param string $path
	 * @param string $title
	 * @param string $description
	 */
	public function addTitleChildrenElement($id,$title,$href=null){
		
		if($this->childrenElementType!='title'){
			die('友情链接组件的子元素类型不是标题类型');
		}
		
		
		$element = new ChildrenElement();
		$element->setId($id)
				->setTitle($title);
				
		if(is_null($href)){
			die('友情链接组件的子元素的链接属性不能为空');
		}
		else{
			$element->setHref($href);
		}
		
		
		$this->childrenElementList[$id] = $element;//如果有相同id的元素就会进行覆盖
		return $this;
	}//function addSlideElement() end
	
	
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//1. 得到基础路径的视图助手，从而得到完整的http绝对路径
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		$phpRenderer = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$phpRenderer->headLink()->appendStylesheet($basePathViewHelper('component/friend-link/images/component.css'));
		
		
		
		//2.将对象中的幻灯片组件远足添加到模版中用于循环
		if($this->childrenElementType=='image'){//只有子元素类型是图片类型的时候才有必要与图片的基准类型进行合并
			foreach($this->slideElementList as $key=>$element){
				$path = $basePathViewHelper(sprintf("%s/%s",$this->imageBasePath,$element->imagePath));
				$this->slideElementList[$key]->setImagePath($path);
			}
		}
		
		$this->setVariable('childrenElementList', $this->childrenElementList);
		
		//3.如果返回类型是html的话，那么就渲染自身的对象，然后返回
		if($returnType=='html'){
			
			$html = $phpRenderer->render($this);
			return $html;
		}
		
		
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



