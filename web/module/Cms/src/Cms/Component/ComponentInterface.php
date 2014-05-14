<?php

namespace Cms\Component;


interface ComponentInterface
{
    
   
	/**
	 *  如果有查询数据的需求，就去查询数据,并且把查询到的数据复制到视图变量中
	 *  如果没有查询数据的需求，那么就根据组件的设置，决定模板需要怎么样进行变化
	 *  
	 *  @param $returnType
	 *  如果返回类型是html,那么返回渲染过后的html内容，在调用的时候作为字符串返回给调用对象，已经完成渲染
	 *  如果返回类型是viewModel,那么不返回任何数值，调用的时候可以将整个组件作为子视图添加到父视图中
	 *  
	 *  因为viewModel中的已经存在默认方法render,而component继承了viewModel,所以不覆盖默认方法
	 *  
	 */
	public function componentRender($returnType='ViewModel');
	
    
	
}