<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Common\UploadFile;


use Etah\Common\Image\Image;
use Etah\Common\Video\Thumb;

class VideoUpload extends AbstractUploadFile
{
	
	public function __construct($file = null){
	
		parent::__construct($file);
		
		//对于上传图片的类进行一些定制化的初始化操作
		
		$this->setAllowExts(array('mp4'))
			 ->setAllowTypes(self::AUTO);
		
		
	}
	//是否需要生成截图
	protected $needThumb = FALSE;
	
	//缩略图的基本名称，最后的文件名形如  thumbBaseName_800X600.jpg
	protected $thumbBaseName = NULL;
	
	//缩略图存储路径
	protected $thumbPath = NULL;
	
	/*
	 * 缩略图形式，包含大小和个数，
	 * 格式为
	 *  array(
	 *  
	 *  '800x600',
	 *  '600x400',
	 *  '400x300'
	 *  )
	 */
	protected $thumbSizeList = array();
	
	/**
	 * @todo 检查缩略图尺寸参数是否合法
	 * @param array $thumbSizeList
	 * @throws \Exception
	 */
	
	public function getNeedThumb()
	{
		return $this->needThumb;
	}
	
	public function setNeedThumb($needThumb)
	{
		$this->needThumb = $needThumb;
		return $this;
	}
	
	
	
	public function getThumbSizeList()
	{
		return $this->thumbSizeList;
	}
	
	public function setThumbSizeList($thumbSizeList)
	{
		if (!is_array($thumbSizeList)){
			throw new \Exception('缩略图参数只能是格式为\'800x600\'的数组');
		}
		$this->thumbSizeList = $thumbSizeList;
	}
	
	
	public function getThumbBaseName()
	{
		return $this->thumbBaseName;
	}	
	
	public function setThumbBaseName($thumbBaseName)
	{
		$this->thumbBaseName = $thumbBaseName;
		return $this;
	}
	
	public function getThumbPath()
	{
		return $this->thumbPath;
	}
	
	
	public function setThumbPath($thumbPath)
	{
		$this->thumbPath = $thumbPath;
		return $this;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \Etah\Common\UploadFile\AbstractUploadFile::upload()
	 * 
	 */
	
	public function upload($savePath = NULL){
		
		parent::upload($savePath);
		
		if($this->needThumb){
			
			if (sizeof($this->thumbSizeList) < 1 ){

				throw new \Exception('缩略图参数只能是格式为\'800x600\'的数组');
			}
			
			$fileInfo = $this->getUploadFileInfo();
			
			
			if ($this->thumbBaseName == null){
				$this->setThumbBaseName(md5($fileInfo['filename']));
			}
			
			$this->setThumbPath($fileInfo['destination']);
			
			$this->createThumb();
		}
	}
	
	
	
	
	/**
	 * 根据配置产生缩略图
	 * 
	 * @todo 检查缩略图尺寸参数
	 * 
	 * 
	 */
	
	private  function createThumb()
	{
		$screenshotPath = null;
		
		$uploadFileInfo = $this->getUploadFileInfo();
		
		$thumb = new Thumb();
		
		$thumb->setVideoPath($uploadFileInfo['fileName']);
		
		$thumb->setThumbSize($this->getThumbSizeList());
		
		$thumb->generate();
				
	}
	
	
	
	
}