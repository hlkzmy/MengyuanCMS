<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Common\UploadFile;

use Etah\Common\UploadFile\AbstractUploadFile;

class DocumentUpload extends AbstractUploadFile
{
	
	public function __construct($file = null){
	
		parent::__construct($file);
		
		//对于上传图片的类进行一些定制化的初始化操作
		
		$this->setAllowExts(array('doc','docx','zip','tar','ppt','xls'))
			 ->setAllowTypes(self::AUTO);
		
		
	}
	
	
}