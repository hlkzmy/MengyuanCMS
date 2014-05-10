<?php

namespace Etah\Mvc\Form;


use Zend\Form\Element\Button;
use Zend\Form\Element\Submit;
use Zend\Form\Form;
use Zend\Form\Element\Hidden;
use Zend\Form\Element\Text;

class PagerForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct ('pagerForm');

        $this->setAttribute('method','post');
        
        $this->setAttribute('id','pagerForm');
        
        $this->setAttribute('class','pagerForm');
        
        $this->setAttribute('onsubmit', 'return navTabSearch(this);');
        
        $id = new Text();
        $id->setName('id');
        
        $this->add($id);
        
    }//function __construct() end
    
    
    /**
     * 在查找带回的过滤页面页面上增加一个带回数据的按钮
     * 原型为：<input  type="button" multLookup="group" warn="请至少选择一个对象"  value='确认选择' />
     */
    
    public function appendFormLookupSubmitElement(){
    	
    	$button = new Button();
    	$button->setName('lookupSubmit');
    	$button->setLabel('确认选择');
    	$button->setAttribute('warn','请选择一条记录');
    	$button->setAttribute('multLookup','group');
    	$button->setAttribute('notRenderLabel','true');
    	
    	$this->add($button);
    	
    	
    }//function appendFormLookupSubmitElement() end
    
    
    /**
     * 根据配置数组中的字段的列表 和 具体的form 来对表单元素进行处理
     *
     * 1.循环字段列表，如果表单元素中没有字段列表中的字段，就根据配置文件来创建这个表单元素，这个过程是往表单中添加表单元素
     *
     * 2.循环表单元素列表，如果表单元素在字段列表中不存在，那么将这个表单元素从表单中移除，这个过程是从表单中移除表单元素
     *
     * 最终保持表单元素与配置文件中的字段个数一致，不多不少
     *
     */
    
    public function completeFormElement($columns,$readConfig){
    
    	//循环字段列表，如果表单中不存在某一个字段，那么添加向表单中添加这个属性
    	foreach($columns as $column){
    
    		if(!$this->has($column)){
    			//如果没与这个元素
    			$this->formatFormElement($column,$readConfig);
    		}
    
    	}//foreach end
    		
    		
    	//循环表单元素，然后移除不在字段列表的表单元素
    	//如果一个表单元素在字段列表中，那么就对它根据配置文件进行格式化
    	foreach($this as $element){
    
    		$name =  $element->getName();
    		//得到表单对象的name值
    
    		if(!in_array($name,$columns)){
    			//如果从BaseForm中的元素对象不在当前表单对象的字段列表中，那么就把这个字段移除掉
    			$this->remove($name);
    			continue;
    			//然后直接跳出循环
    		}
    
    		
    		$this->formatFormElement($name,$readConfig);
    
    	}//foreach end
    
    }//function completeFormElement() end
    
    
    /**
     * 根据配置数组中关于表单中某个元素的配置来对表单中元素进行格式化处理
     * 对于现阶段的需求，有如下的分析
     *
     * 1.如果指定的元素在表单中不存在的话，那么就创建；如果指定的元素在表单中存在的话，就对表单元素进行修改
     *
     * 2.要根据配置文件对于表单元素填写label值,这个是必须的
     *
     * 3.添加和设置属性，这个元素中是覆盖设置，如果设置相应的属性与BaseForm属性相冲突，就会覆盖BaseForm中的属性
     *   简单点说就是直接setAttribute，不去判断BaseForm中有没有相关属性
     *
     * @param $array $formElementConfig
     *
     */
    
    public function formatFormElement($name,$readConfig){
    
    	$formElementConfig = $readConfig['pager_form']['columns'][$name];
    	
    	if(isset($formElementConfig['form_control']) && $this->has($name)){
    		//只有在设置了form_control的时候才进行相关的判断，否则就把BaseForm中的表单类型作为自己的表单类型
    			
    		$type = $this->get($name)->getAttribute('type');
    		//从继承得到的表单元素得到类型,BaseForm中对于表单元素的类型的定义
    		//如果在BaseForm中定义的是一个text类型，但是在具体的表单的时候发现需要使用lookup类型
    		//那么就删除BaseForm中的元素，然后使用具体表单的配置再进行创建
    
    		$formControl = $formElementConfig['form_control'];
    
    		if($formControl!=$type){
    			//如果两者不一样的话，就进行删除
    			$this->remove($name);
    		}
    			
    	}//if end
    
    	if($this->has($name)){
    		//如果表单中有这个元素，那么就对这个元素进行修改
    		$this->modifyFormElement($name,$readConfig);
    	}
    	else{
    		//如果表单中不存在这个元素，就对这个元素进行创建
    		$this->createFormElement($name,$readConfig);
    	}
    
    }//function formatFormElement() end
    
    
    protected function createFormElement($name,$readConfig){
    
    	$formElementConfig = $readConfig['pager_form']['columns'][$name];
    	 
    	if(!isset($formElementConfig['form_control'])){
    		die('添加对象的页面中存在表单元素'.$name.'的控件类型form_control没有被设定');
    	}
    
    	$formControl = ucfirst( strtolower( $formElementConfig['form_control'] ));
    
    	$formControl = 'Zend\\Form\\Element\\'.$formControl;
    
    	$formElement = new $formControl();
    
    	if(isset($formElementConfig['label'])){
    		$formElement->setLabel($formElementConfig['label']);
    	}
    	else if(isset($readConfig['template_display_columns'][$name]['label'])){
    		$formElement->setLabel($readConfig['template_display_columns'][$name]['label']);
    	}
    	else{
    		die('列表对象的模板字段'.$name.'的label值既没有被设定，也没有在template_display_columns找到存在表单元素');
    	}
    	
    	$formElement->setName($name);
    
    	if(isset($formElementConfig['attribute'])){
    		//设置属性
    		$formElement->setAttributes($formElementConfig['attribute']);
    	}
    
    	$this->add($formElement);
    
    }//function createFormElement() end
    
    protected function modifyFormElement($name,$readConfig){
    
    	$formElementConfig = $readConfig['pager_form']['columns'][$name];
    	
    	if(isset($formElementConfig['label'])){
    		$this->get($name)->setLabel($formElementConfig['label']);
    	}
    	else if(isset($readConfig['template_display_columns'][$name]['label'])){
    		$this->get($name)->setLabel($readConfig['template_display_columns'][$name]['label']);
    	}
    	else{
    		die('列表对象的模板字段'.$name.'的label值既没有被设定，也没有在template_display_columns找到存在表单元素');
    	}
    	if(isset($formElementConfig['attribute'])){
    		$this->get($name)->setAttributes($formElementConfig['attribute']);
    	}

    
    }//function modifyFormElement() end
    
    
    /**
     * 因为形成表单的过程在不断的添加元素和减去元素,中间表单元素的顺序往往不是设定的顺序
     * 所以在最后按照配置文件中顺序重新排一次表单的顺序,保证形成的页面表单元素的排列顺序与配置文件中一直
     * $param array $columns 从配置文件中读取的字段顺序
     */
    
    public function sortFormElement($columns){
    
    	$formElementList = $this->getElements();
    		
    	foreach($this as $element){
    		$name = $element->getName();
    		$this->remove($name);
    	}
    		
    	foreach($columns as $column){
    		$this->add($formElementList[$column]);
    	}
    
    }//function sortFormElement() end
    
    
    public function appendFormElement($config){
    	
    	//添加两个隐藏域
    	$currentPageNumber =  new Hidden('currentPageNumber');
    	$currentPageNumber->setValue(1);
    	$this->add($currentPageNumber);
    	
    	
    	$pageRowCount =  new Hidden('pageRowCount');
    	$pageRowCount->setValue($config['pagination']['page_row_count']);
    	$this->add($pageRowCount);
    	
    	$sumbit = new Submit();
    	$sumbit->setValue('检索数据');
    	$sumbit->setName('submit');
    	$this->add($sumbit);
    	
    }//function appendFormElement() end
    
    
    
    
    
}
