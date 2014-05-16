<?php

namespace Cms\Component\Slide\Javascript;


class SlideElement {
	
	public $id;//一个幻灯片元素在幻灯片组件中的位置，用于后期删除
	
	public $imagePath = null;//图片的路径
	
	public $title = null;//图标的标题信息
	
	public $description = null;//图片的描述性信息
	
	public $href = null;//设置图片链接到的地址
	
	
	public function setId($id){
		$this->id = $id;
		return $this;
	}
	
	public function setImagePath($path){
		$this->imagePath = $path;
		return $this;
	}//function __construct() end
	
	public function setTitle($title){
		$this->title = $title;
		return $this;
	}
	
	public function setDescription($description){
		$this->description = $description;
		return $this;
	}
	
	public function setHref($href){
		$this->href = $href;
		return $this;
	}
	
	
	
	
	
}//class end



