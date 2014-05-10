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
use Etah\Mvc\Form\Element\DwzUploadify as DwzUploadifyElement;
use Zend\Form\Exception;

class FormDwzUploadify extends FormInput
{
    
	//认为的设定查找带回的组件所能使用的属性
 	protected $validTagAttributes = array(
 										'id'=>true,
					        			'swf'=>true,
 										'width'=>true,
 										'height'=>true,
					        			'uploader'=>true,
					        			'formData'=>true,
 										'buttonClass'=>true,
					        			'buttonImage'=>true,
					        			'fileSizeLimit'=>true,
					        			'fileTypeDesc'=>true,
					        			'fileTypeExts'=>true,
        		        				'onUploadError'=>true,
 										'onUploadSuccess'=>true,
 			
 										//这两个属性不需要用户设置，所以必须设置的属性
 										'uploadify'=>true,
 										'type'=>true
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
        if (!$element instanceof DwzUploadifyElement) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s requires that the element is of type Zend\Form\Element\DwzUploadify',
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
        								'swf',
        								'width',
        								'height',
        								'uploader',
        								'formData',
        								'buttonClass',
        								'buttonImage',
        								'fileSizeLimit',
        								'fileTypeDesc',
        								'fileTypeExts',
        								'onUploadError',
        								'onUploadSuccess'
        							);
        
        
        foreach($attributePrepareArray as $attribute){
        	
        	if(!$element->hasAttribute($attribute)){
        		
        		throw new Exception\DomainException(sprintf(
        				'%s 所扩展的uploadify的dwz上传组件需要设置%s属性',
        				__METHOD__,
        				$attribute
        		));
        	}
        	
       }//foreach end
        
       
        $attributes['id'] 			=  $attributes['id'].rand(0, 100000);
        $attributes['uploadify'] 	= 'true';
        $attributes['type']      	= 'file';
        
        return sprintf(
            			'<input %s%s',
            			$this->createAttributesString($attributes),
           				$this->getInlineClosingBracket()
                     );
        			
	}

    /**
     * Return input type
     *
     * @return string
     */
    protected function getInputType()
    {
        return 'dwz_uploadify';
    }
}
