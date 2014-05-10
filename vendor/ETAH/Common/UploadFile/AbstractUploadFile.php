<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Common\UploadFile;

use Etah\Common\Folder\Folder;

use Etah\Common\Folder\Permission;

use Zend\Validator\File\MimeType;

use Zend\Validator\File\Extension;

use Zend\Validator\File\Size;

use Zend\InputFilter\FileInput;

use Zend\Filter\File\Rename;

use Zend\File\Transfer\Adapter\Http;

use Etah\Common\UploadFile\AbstractAdapter;

use Etah\Common\UploadFile\MimeTypeArray;

use Zend\Stdlib\Parameters;

/**
 * 本类是用于上传的虚类，定义基本上传方法
 * @author Edward_sj
 *
 */

abstract class AbstractUploadFile extends AbstractAdapter
{
	
	//上传文件
	protected $file = NULL;
	
	//目标路径
	protected $savePath = null;
	
	//上传最大值
	protected $maxSize = -1;
	
	//上传最小值
	protected $minSize = -1;
	
	// 允许上传的文件后缀
	//  留空不作后缀检查
	protected $allowExts = array();
	
	// 允许上传的文件类型
	// 空数组不做检查，auto表示自动根据后缀名检查
	const AUTO = 'auto';
	
	protected $allowTypes = self::AUTO;
	
	//是否覆盖同名文件
	protected $overwrite = FALSE;
	
	//是否自动重命名
	protected $autoRename = FALSE;
	
		
	// 上传文件命名规则
	// 例如可以是 time uniqid com_create_guid 等
	// 必须是一个无需任何参数的函数名 可以使用自定义函数
	protected $renameRule = 'com_create_guid';
	
	//是否自动追加子目录
	protected $autoSubdir = FALSE;
	
	//追加子目录规则
	protected $subdirRule = 'Ymd';
	
	// 上传文件Hash规则函数名
	// 例如可以是 md5_file sha1_file 等
	protected $hashType = 'md5_file';
	
	// 错误信息
	protected $error = '';
	
	// 上传成功的文件信息
	protected $uploadFileInfo = array();
	
	public function getSavePath()
	{
		return $this->savePath;
	}
	
	
	public function setSavePath($savePath)
	{
		$this->savePath = $savePath;
		return $this;
	}

	
	public function getMaxSize()
	{
		return $this->maxSize;
	}
	
	/**
	 * Sets the maximum file size
	 *
	 * File size can be an integer or an byte string
	 * This includes 'B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'
	 * For example: 2000, 2MB, 0.2GB
	 **/
	public function setMaxSize($maxSize)
	{
		$this->maxSize = $maxSize;
		return $this;
	}
	
	
	public function getMinSize()
	{
		return $this->minSize;
	}
	
	
	public function setMinSize($maxSize)
	{
		$this->minSize = minSize;
		return $this;
	}
	
	public function getAllowExts()
	{
		return $this->allowExts;
	}
	
	
	public function setAllowExts($allowExts)
	{
		$this->allowExts = $allowExts;
		return $this;
	}
	
	
	public function getAllowTypes()
	{
		return $this->allowTypes;
	}
	
	
	public function setAllowTypes($allowTypes)
	{
		$this->allowTypes = $allowTypes;
		return $this;
	}
	
	
	public function autoRename()
	{
		return $this->autoRename;
	}
	
	public function setAutoRename($autoRename)
	{
		$this->autoRename = $autoRename;
		return $this;
	}
	
	
	public function overFlow()
	{
		return $this->overflow;
	}
	
	public function setOverFlow($overFlow)
	{
		$this->overflow = $overFlow;
		return $this;
	}
	
	
	public function getRenameRule()
	{
		return $this->renameRule;
	}
	
	public function setRenameRule($renameRule)
	{
		$this->renameRule = $renameRule;
	}
	
	
	public function getHashType()
	{
		return $this->hashType;
	}
	
	public function setHashType($hashType)
	{
		$this->hashType = $hashType;
	}
	
	public function autoSubdir()
	{
		return $this->autoSubdir;
	}
	
	public function setAutoSubdir($autoSubdir)
	{
		$this->autoSubdir = $autoSubdir;
		return $this;
	}
	
	public function getSubdirRule()
	{
		$this->subdirRule;
	}
	
	public function setSubdirRule($subdirRule)
	{
		$this->subdirRule = $subdirRule;
		return $this;
	}
	
	
	public function getErrors()
	{
		return $this->error;
	}
	
	public function getUploadFileInfo()
	{
		return $this->uploadFileInfo;
	}
	
	public  function setFile($file)
	{
		if (!$file instanceof Parameters){
			throw new \Exception('传入的对象只能是file对象');
		}
		$this->file = $file->toArray();
		return $this;
	}
	
	
	
	public function upload($savePath = NULL)
	{
		
		$file = $this->file;
		if(!is_null($savePath)){
			$this->savePath = $savePath;
		}
		
		foreach ($file as $key=>$f){
			$file = $f;
			$name = $key;
			break;
		}
		
		//检查文件
		if(!$this->check($file)){
			throw new \Exception($this->error);
		}
		
		//上传文件
		if (!$this->save($file)){
			throw new \Exception($this->error);
		}
		
		
		
	}
	/**
	 * 用于返回普通文件上传错误
	 * @param unknown_type $errorNo
	 */
	private function errorNo($errorNo) {
		switch($errorNo) {
			case 0:
				return true;
			case 1:
				$this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
				break;
			case 2:
				$this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
				break;
			case 3:
				$this->error = '文件只有部分被上传';
				break;
			case 4:
				$this->error = '没有文件被上传';
				break;
			case 6:
				$this->error = '找不到临时文件夹';
				break;
			case 7:
				$this->error = '文件写入失败';
				break;
			default:
				$this->error = '未知上传错误！';
		}
		return false;
	}
	
	
	/**
	 * 单文件检测
	 * @param file $file
	 * @return boolean
	 * 
	 */
	
	private function check($file)
	{
		//传统文件检测
		if(!$this->errorNo($file['error']))
		{
			return false;
		}
		
		$fileInput = new FileInput();
		$fileInput->setValue($file);
		
		//开始自定义检测
		
		//1.大小检测
		
		$size = new Size();
		$size->setMessage('只允许上传小于%max%大小的文件',$size::TOO_BIG);
		$size->setMessage('只允许上传大于%min%大小的文件',$size::TOO_SMALL);
		if ($this->maxSize > 0){
			$size->setMax($this->maxSize);
		}
		if ($this->minSize > 0){
			$size->setMin($this->minSize);
		}
		$fileInput->getValidatorChain()->addValidator($size);
		
		//2.后缀检测
		if (sizeof($this->allowExts) > 0){
			$ext = new Extension($this->allowExts);
			$extString = implode(',',$this->allowExts);
			
			$ext->setMessage('只允许上传后缀名为'.$extString.'的文件');
			$fileInput->getValidatorChain()->addValidator($ext);
		}
		//3.文件类型检测
		if($this->allowTypes == 'auto'){
			
			$this->allowTypes = array();
			$mimeTypeArray = MimeTypeArray::getMimeType();
			
			//从后缀取得文件类型后缀
			foreach ($this->allowExts as $ext){
				
				if(isset($mimeTypeArray[$ext])){
					
					if (is_array($mimeTypeArray[$ext])){
						foreach ($mimeTypeArray[$ext] as $mineType){
							array_push($this->allowTypes,$mineType);
						}
					}else {
						array_push($this->allowTypes,$mimeTypeArray[$ext]);
					}
				}else {
					
					$this->error = '后缀名'.$ext.'不是常见的后缀名，请检查您的后缀或与管理员联系';
					return false;
				}
			}
		}
		
		if(sizeof($this->allowTypes) >0 ){
			
			$fileType = new MimeType($this->allowTypes);
			$fileType->setMessage('不正确的文件MIME类型',$fileType::FALSE_TYPE);
			$fileType->setMessage('不能正常读取文件的MIME类型',$fileType::NOT_READABLE);
			$fileInput->getValidatorChain()->addValidator($fileType);
			
		}
		
		//检查完毕
		if (!$fileInput->isValid()){
			
			foreach ($fileInput->getMessages() as $error){
				$this->error = $error;
				return false;
			}
			
		}
		return true;
		
	}
	
	
	
	
	
	
	
	private  function save($file)
	{
		
		if (empty($this->savePath)){
			$this->error  =  '没有指定上传目录';
			return false;
		}
		
		if ($this->autoSubdir){
			
			$this->savePath = $this->savePath.date($this->subdirRule).'/';
			//创建上传目录
			Folder::create($this->savePath);
		}else{
			Folder::create($this->savePath);
		}
		
		// 检查上传目录
		Permission::checkDirectory($this->savePath);
		
		
		//产生文件名
		
		if ($this->autoRename){
			
			$ext = strrchr($file['name'], '.');

			if(function_exists($this->renameRule)) {
				$newName = call_user_func($this->renameRule).$ext;
			}else{
				$newName = md5($file['name'].time()).$ext;
			}
			
		}else {
			$newName = $file['name'];
		}

		$filename = $this->savePath.$newName;
			
		if($this->overwrite == false && file_exists($filename)) {
			// 不覆盖同名文件
			$this->error	=	$newName.'文件已经存在！';
			return false;
		}
		
		$target = $filename;
		$sorce = $file['tmp_name'];
		
		$options = array(
				'target'=>$target,
				'sorce'=>$sorce,
				'overwrite'=>$this->overwrite,
				);
		$rename = new Rename($options);
		
		$uplaod = new Http();
		$uplaod->addFilter($rename);
		
		if(!$uplaod->receive()){
			foreach ($uplaod->getMessages() as $error){
				$this->error = $error;
				return false;
			}
		}
		
		//上传成功后开始记录文件信息
		$this->uploadFileInfo['newName']	= $newName;
		$this->uploadFileInfo['oldName']	  = $file['name'];
		$this->uploadFileInfo['fileName']     = $uplaod->getFileName();
		$this->uploadFileInfo['destination']  = $uplaod->getDestination();
		$this->uploadFileInfo['size']     	  = $uplaod->getFileSize();
		$this->uploadFileInfo['mimeType']     = $uplaod->getMimeType();
		
		
		return true;
		
	}
	
	
	
	
	// 自动转换字符集 支持数组转换,从其它字符集到utf-8    这部分暂时没用
	private function autoCharset($fContents) {
		
		$to = 'UTF-8';
		if (empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
			//如果编码相同或者非字符串标量则不转换
			return $fContents;
		}
		$encode = mb_detect_encoding($fContents, array('ASCII','GB2312','GBK','CP936','UTF-8')); 
		
		if ($encode == 'UTF-8'){
			return $fContents;
		}
		if (function_exists('iconv')) {
			return iconv($to,$encode,$fContents);
		} else {
			return $fContents;
		}
	}
	

	
	
	
}