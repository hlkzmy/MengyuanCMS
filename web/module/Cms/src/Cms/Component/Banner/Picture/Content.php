<?php

namespace Cms\Component\Banner\Picture;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $bannerPictureName = null;//banner图片的名称
	
	protected $bannerPath = '/theme/default/common/banner';//相当于public的路径
	
	protected $width  = '100%';
	
	protected $height = '100%';
	
	protected $alt = '图片提示';
	
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		
		
		
		$this->setWidth($this->width);
		$this->setHeight($this->height);
		$this->setAlt($this->alt);
		$this->setTemplate('Cms/Component/Banner/Picture/Template/Content');
	}//function __construct() end
	
	
	/**
	 * 设置栏目的标题
	 */
	public function setWidth($width){
		$this->setVariable('width', $width);
		return $this;
	}//function setColumnTitle() end
	
	/**
	 * 设置栏目要读取哪个分类之下的文章
	 * @param $categoryId 
	 */
 	public function setHeight($height){
		$this->setVariable('height', $height);
		return $this;
	}//function setCategoryId() end
	
	
	/**
	 * 设置一个栏目之下显示文章的总数
	 */
 	public function setAlt($alt){
 		$this->setVariable('alt', $alt);
		return $this;
	}
	
	public function setBannerPath($bannerPath){
		$this->bannerPath = $bannerPath;
		return $this;
	}
	public function setBannerPictureName($name){
		$this->bannerPictureName = $name;
		return $this;
	}
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		
		if(is_null($this->bannerPictureName)){
			$this->setBannerPictureName('default_banner.jpg');
		}
		
		$relativePath = sprintf("%s/%s",$this->bannerPath,$this->bannerPictureName);
		
		$this->setVariable('imgSrc', $basePathViewHelper($relativePath));
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



