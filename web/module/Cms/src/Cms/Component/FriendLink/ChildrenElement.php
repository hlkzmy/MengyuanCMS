<?php

namespace Cms\Component\FriendLink;


class ChildrenElement {
	
	public $id;//一个友情连接的id，便于后期删除
	
	public $imagePath = null;//图片的路径
	
	public $title = null;//友情链接的标题
	
	public $alt = null;//如果友情链接的是图片类型，那么图片上的alt信息
	
	public $href = null;//友情链接的地址
	
	public $description = null;//友情链接的描述信息
	
	
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
	
	public function setAlt($alt){
		$this->alt = $alt;
		return $this;
	}
	
	public function setHref($href){
		$this->href = $href;
		return $this;
	}
	
	
	
	
	
}//class end



