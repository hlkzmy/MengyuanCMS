<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Common\UploadFile;

use Zend\Stdlib\Parameters;


use Etah\Common\Folder\Folder;

/**
 * 本例是用于各种上传的基虚类适配器,定义某些操作使用的工具类
 * @abstract
 * @author Edward_sj
 *
 */

abstract class AbstractAdapter
{


	
	//上传类型
	protected $uploadType = NULL;
	
	
	
	public function __construct($file = null){
	
	
		if(!is_null($file)){
			if (!$file instanceof Parameters){
				throw new \Exception('初始化不正确,初始化传入的对象只能是file对象');
			}
			$this->file = $file->toArray();
		}
		
		if($this->getPlatform() =='Windows NT'){
			
			Folder::setMethod('recursion');
			
		}
		
		
		
	}
	
	
	private  function getPlatform(){
		
		$operationSystemName =php_uname('s');
		
		return $operationSystemName;
	}
	
	
	public function getUploadType()
	{
		return $this->uploadType;
	}
	
	
	protected function setUploadType($uploadType)
	{
		$this->uploadType = $uploadType;
		return $this;
	}
	
	
	
}