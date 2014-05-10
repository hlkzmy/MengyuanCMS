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
use Etah\Mvc\Form\Element\DwzLookup as DwzLookupElement;
use Zend\Form\Exception;

class FormDwzLookup extends FormInput
{
    
	//认为的设定查找带回的组件所能使用的属性
 	protected $validTagAttributes = array(
										'width' =>true,
							 			'height'=>true,
										'name'=>true,
							 			'size'=>true,
							 			'lookupgroup'=>true,
 										'warn'=>true,
 										'hidden_value' =>true,
 										'display_value'=>true
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
        if (!$element instanceof DwzLookupElement) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Zend\Form\Element\DwzLookup',
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
        $name  = $element->getAttribute('name');
        if (!isset($name)) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置打开页面的name属性',
        			__METHOD__
        	));
        }
        
        $width = $element->getAttribute('width');
        if (!isset($width) || (!is_numeric($width) && $width != 'auto' ) ) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置打开页面的width属性，属性必须为数字',
        			__METHOD__
        	));
        }
        
        $height = $element->getAttribute('height');
        if (!isset($height) || !is_numeric($height)) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置打开页面的height属性，属性必须为数字',
        			__METHOD__
        	));
        }
        
        $lookupgroup = $element->getAttribute('lookupgroup');
        if (!isset($lookupgroup) || !ctype_alpha($lookupgroup)) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置Lookupgroup属性，属性必须为字母',
        			__METHOD__
        	));
        }
        
        $href = $element->getAttribute('href');
        if (!isset($lookupgroup)) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置href属性',
        			__METHOD__
        	));
        }
        
        $label = $element->getAttribute('label');
        if (!isset($label)) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置label属性',
        			__METHOD__
        	));
        }
        
        $size = $element->getAttribute('size');
        if (!isset($label)) {
        	throw new Exception\DomainException(sprintf(
        			'%s 所扩展的查找带回组件需要设置size属性',
        			__METHOD__
        	));
        }

		//warn 是可选的属性，主要是用于级联        
        $warn = $element->getAttribute('warn');
        
        
        //下面开始最没有技术含量的工作，拼接字符串
        $closingBracket        = $this->getInlineClosingBracket();
        //得到input标签的结束符号，是'/>'还是'>'
        
        
        //拼接显示给用户带回内容的文本框
        $displayInputName = $lookupgroup.'.name';
        $displayInput =  sprintf(
            				"<input type='text' style='float:left;' size='%s' disabled='disabled' name='%s' value='%s'  %s",
           					 $size,
        					 $displayInputName,
        					 $element->getAttribute('display_value'),
            				 $closingBracket
        );
        
        //拼接传递回后台的隐藏域的文本框
        $hiddenInputName  = $lookupgroup.'.'.$name;
        $hiddenInput =  sprintf(
        		"<input type='hidden' id='%s' name='%s'  value='%s'  %s",
        		$name,
        		$hiddenInputName,
        		$element->getAttribute('hidden_value'),
        		$closingBracket
        );
        
        //拼接得到触发查找带回事件的超链接标签
        $rendered = sprintf(
        		"<a class='btnLook' lookupgroup='%s' href='%s' width='%s' height='%s' warn='%s' >%s</a>",
        		$lookupgroup,
        		$href,
        		$width,
        		$height,
        		$warn,
        		$label
        );
        
        $rendered =  $displayInput.$hiddenInput.$rendered;
        			
		return $rendered;
    }

    /**
     * Return input type
     *
     * @return string
     */
    protected function getInputType()
    {
        return 'dwz_lookup';
    }
}
