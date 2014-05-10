<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Etah\Mvc\View\Helper\Form\Dwz;

use Zend\Form\View\Helper\FormInput;
use Zend\Form\ElementInterface;
use Etah\Mvc\Form\Element\DwzDatePicker as DwzDatePickerElement;
use Zend\Form\Exception;


class FormDwzDatePicker extends FormInput
{
    
	//认为的设定查找带回的组件所能使用的属性
 	protected $validTagAttributes = array(
 										'id'=>true,	
 										'name'=>true,
 										'class'=>true,
 										'datefmt'=>true,
 										//这个属性不需要用户设置，所以必须设置的属性
 										'type'=>true,
 										
 									);
    
    /**
     * Render a form <input> element from the provided $element
     *
     * @param  ElementInterface $element
     * @throws Exception\InvalidArgumentException
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element)
    {
    	
    	
        if (!$element instanceof DwzDatePickerElement) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Zend\Form\Element\DwzDatePicker',
                __METHOD__
            ));
        }

        $attributes            = $element->getAttributes();
        //得到表单元素的属性列表
        
        //清除掉不在可用属性列表中的属性
        foreach($attributes as $key=>$attribue){
        	if(!array_key_exists($key, $this->validTagAttributes)){
        		unset($attributes[$key]);
        	}
        }
        
        //以下对于几个必要的属性进行是否被正确判断
        //因为需要判决的属性太多，所以尝试用一个属性数组来循环判断
        $attributePrepareArray = array(
        								'id',
        								'name',
        								'class',
        							);
        
        
        foreach($attributePrepareArray as $attribute){
        	
        	if(!$element->hasAttribute($attribute)){
        		
        		throw new Exception\DomainException(sprintf(
        				'%s 所扩展的datepicker的dwz日期选择组件需要设置%s属性',
        				__METHOD__,
        				$attribute
        		));
        	}
        	
       }//foreach end
        
        $attributes['type'] 	= 'text';
        $attributes['readonly'] = 'true';
       
        $inputElement =  sprintf('<input style="float:left;" value="%s" %s%s',
        						 $element->getValue(),
	            				 $this->createAttributesString($attributes),
           				         $this->getInlineClosingBracket()
                    	 );
        
        $rendered = $inputElement.'<a class="inputDateButton" href="javascript:;">选择</a>';
        
        return $rendered;
        
    }

    /**
     * Return input type
     *
     * @return string
     */
    protected function getInputType()
    {
        return 'dwz_date_picker';
    }
}
