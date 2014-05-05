<?php

namespace Web\Plugin\Article;

use Zend\View\Model\ViewModel;//视图列表


class Column extends ViewModel{
	
	public $columnTitle = null;//栏目的标题
	
	function __construct(){
		
		$this->setTemplate('web/component/article/column');
	}//function __construct() end
	
	/**
	 * 设置栏目的标题
	 */
	public function setColumnTitle($title){
		$this->columnTitle = $title;
		$this->setVariable('columnTitle', $title);
		return $this;
	}//function setColumnTitle() end
	
	
	/**
	 * 得到栏目的标题
	 */
	public function getColumnTitle(){
		return $this->columnTitle;
	}//function setColumnTitle() end
	
	
	
	
	
	
	
	
}//class end



