<?php

namespace Video\Controller;

use Etah\Common\Video\Translate\Translate;
use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use Zend\Db\Sql\Where;
use Etah\Common\ArrayOperation\Key as ArrayKeyOperation;
use Etah\Common\Video\Thumb as VideoThumb;
use Etah\Common\Video\Chapter as VideoChapter;
use Etah\Common\Video\Info as VideoInfo;
use Etah\Common\File\Info as FileInfo;
use Etah\Common\Folder\Travel;
use Etah\Common\Image\Image;

class VideoController extends BaseController {
	public function __construct() {
		parent::__construct ();
		
		// 注册数据表对象
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'VideoModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'VideoFilterModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'VideoPlayinfoModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'VideoSortModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'VideoLabelModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'LabelModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'AreaModel' );
		
		$this->registDatabaseModel ( $this->serviceManager, 'Base', 'Model', 'UserModel' );
		
		// 注册表单对象
		$this->registForm ( $this->serviceManager, 'Resource', 'Video', 'VideoForm' );
		
		// 注册Filter对象
		
		$this->registFilter ( $this->serviceManager, 'VideoFilter' );
		
		$this->registFilter ( $this->serviceManager, 'VideoFilterFilter' );
		
		$this->registFilter ( $this->serviceManager, 'VideoPlayInfoFilter' );
		
		$this->registFilter ( $this->serviceManager, 'LabelFilter' );
		
		$this->registFilter ( $this->serviceManager, 'VideoLabelFilter' );
	} // function __construct() end
	
	/**
	 * 为了异步
	 */
	public function asynchronous($source, $target, $id) {
		
		// 设置视频状态为转码中
		$this->videoModel->updateRowById ( $id, array (
				'translate_status' => 'T' 
		) );
		
		$CustomerConfigPath = WEBSITE_DISK_PATH . "/frontend/config/customer/website.php";
		
		$CustomerConfig = $this->FormatConfigArray ( $CustomerConfigPath, 'website' );
		
		$local_server_ip = $CustomerConfig ['local_server_ip'];
		
		$url = $this->url ()->fromRoute ( 'resource', array (
				'controller' => 'video',
				'action' => 'translate' 
		) );
		
		$url = sprintf ( "http://%s%s?resource=%s&id=%s", $local_server_ip, $url, $target, $id );
		
		file_put_contents ( FFMPEG_DISK_PATH . 'TraslateLog.log', $url . "\r\n", FILE_APPEND );
		
		// 创建cURL资源
		$ch1 = curl_init ();
		// 指定URL和适当的参数
		curl_setopt ( $ch1, CURLOPT_URL, $url );
		curl_setopt ( $ch1, CURLOPT_HEADER, 0 );
		
		// 创建cURL批处理句柄
		$mh = curl_multi_init ();
		// 加上前面两个资源句柄
		curl_multi_add_handle ( $mh, $ch1 );
		// 预定义一个状态变量
		$active = null;
		// 执行批处理
		$mrc = curl_multi_exec ( $mh, $active );
		// 关闭各个句柄
		curl_multi_remove_handle ( $mh, $ch1 );
		// 关闭批处理
		curl_multi_close ( $mh );
	}
	private function FormatConfigArray($CustomerConfigPath, $key) {
		if (! file_exists ( $CustomerConfigPath )) {
			die ( '网站用户自定义配置文件丢失' );
		}
		$CustomerConfigArray = require ($CustomerConfigPath);
		
		return $CustomerConfigArray [$key];
	}
	
	/**
	 * 转码控制
	 */
	public function translateAction() {
		try {
			
			$request = $this->getRequest ();
			
			$resourcePath = $request->getQuery ( 'resource' );
			
			$id = $request->getQuery ( 'id' );
			
			$translate = new Translate ();
			
			$translate->ffmpegPath ( FFMPEG_DISK_PATH )->setSourceVideoPath ( $resourcePath );
			
			$translate->doTraslate ();
			
			// 由于采集视频长度的代码只能采集mp4，所以在转码之后需要重新采集一遍并且更新数据库
			
			$videoLength = $this->getVideoLength ( $translate->getTargetVideoPath () );
			$size = $this->getVideoSize ( $translate->getTargetVideoPath () );
			
			$this->videoPlayinfoModel->updateRowById ( $id, array (
					'size' => $size,
					'length' => $videoLength 
			) );
			
			$this->videoModel->updateRowById ( $id, array (
					'translate_status' => 'Y' 
			) );
		} catch ( \Exception $e ) {
			file_put_contents ( FFMPEG_DISK_PATH . 'TraslateLog.log', $e->getMessage () . "\r\n", FILE_APPEND );
		}
	}
	
	/**
	 * 单个或批量生成视频的缩略图
	 * 1.用来解决个别文件的图片出不来的问题
	 * 2.或者是我手动直接拷贝的文件的时候，图片缺失的问题，我能手动的添加数据库，但是没有办法手动生成图片
	 */
	public function thumbAction() {
		$request = $this->getRequest ();
		
		if (! $request->isXmlHttpRequest ()) {
			die ( '请不要尝试非法操作，谢谢您的合作！' );
		}
		
		$postData = $request->getPost ()->toArray ();
		
		$videoIdList = $postData ['ids'];
		
		$config = $this->serviceManager->get ( 'config' );
		
		$videoThumbSizeList = $config ['video_thumb_size_list'];
		// 得到缩略图的尺寸的大小列表
		
		$firstThumbSize = array_shift ( $videoThumbSizeList );
		
		try {
			
			$videoThumb = new VideoThumb ();
			
			$image = new Image ();
			
			foreach ( $videoIdList as $videoId ) {
				
				$videoDirectoryPath = sprintf ( "%s/%s", realpath ( VIDEO_DISK_PATH ), $videoId );
				// 得到视频具体的文件夹的路径
				
				if (! is_dir ( $videoDirectoryPath )) {
					// 如果视频文件夹不存在的话，就跳过这个文件夹，避免进入文件递归器，然后发生错误
					continue;
				}
				
				$videoFileList = Travel::getChildFileList ( $videoDirectoryPath, array (
						'mp4' 
				), true );
				
				$thumbFileList = Travel::getChildFileList ( $videoDirectoryPath, array (
						'jpg' 
				), true );
				
				foreach ( $thumbFileList as $thumbFilePath ) {
					unlink ( $thumbFilePath );
				}
				
				$videoThumb->setThumbSize ( $firstThumbSize );
				
				foreach ( $videoFileList as $videoPath ) {
					
					$videoThumb->setVideoPath ( $videoPath );
					
					$videoThumb->generate ();
					
					$thumbBaseName = $videoThumb->getThumbBaseName ();
					
					$sourceImagePath = $videoThumb->getThumbPath ();
					
					foreach ( $videoThumbSizeList as $thumbSize ) {
						
						$widthAndHeightArray = explode ( "x", $thumbSize );
						
						$width = $widthAndHeightArray [0];
						
						$height = $widthAndHeightArray [1];
						
						$thumbPath = sprintf ( '%s/%s_%s.jpg', $videoDirectoryPath, $thumbBaseName, $thumbSize );
						
						$image->thumb ( $sourceImagePath, $thumbPath, 'jpg', $width, $height, $interlace = true );
					} // foreach end 循环缩略图的每一个尺寸
					  
					// 更新视频播放表的信息
					$videoChapter = new VideoChapter ();
					
					$filename = basename ( $videoPath );
					
					$chapterNumber = VideoChapter::returnChapterNumberByFilename ( $filename );
					
					$where = new Where ();
					$where->equalTo ( 'id', $videoId );
					$where->equalTo ( 'filename', $filename );
					$where->equalTo ( 'chapter_number', $chapterNumber );
					
					$this->videoPlayinfoModel->updateRowByCondition ( $where, array (
							'thumb' => $thumbBaseName 
					) );
				} // 循环视频列表，一个文件夹中可能有多个视频列表
				  
				// 更新数据库中的视频表的信息
				$this->videoModel->updateRowById ( $videoId, array (
						'thumb' => $thumbBaseName 
				) );
			} // 循环每一个视频id，因为是批量生成
		} catch ( \Exception $e ) {
			$this->ajaxReturn ( '300', $e->getMessage () );
		}
		
		$this->ajaxReturn ( '200', '恭喜您，生成缩略图视频成功！' );
	} // function generateVideoThumb() end
	public function getVideoSortIdLookupHref() {
		$routeParam = array (
				'controller' => 'video',
				'action' => 'lookup',
				'source' => 'resource.video.create',
				'name' => 'video_sort_id' 
		);
		
		$url = $this->url ()->fromRoute ( 'resource', $routeParam );
		
		return $url;
	} // function getLookupString() end
	public function getSchoolIdLookupHref() {
		$routeParam = array (
				'controller' => 'video',
				'action' => 'lookup',
				'source' => 'resource.video.create',
				'name' => 'school_id' 
		);
		
		$url = $this->url ()->fromRoute ( 'resource', $routeParam );
		
		return $url;
	} // function getAreaIdLookupString() end
	public function getSchoolIdLookupPostUrl() {
		$url = $this->url ()->fromRoute ( 'resource', array (
				'controller' => 'video',
				'action' => 'append' 
		) );
		
		return $url;
	} // function getVideoSortIdLookupPostUrl() end
	public function getVideoSortIdLookupPostUrl() {
		$url = $this->url ()->fromRoute ( 'resource', array (
				'controller' => 'video',
				'action' => 'append' 
		) );
		
		return $url;
	} // function getVideoSortIdLookupPostUrl() end
	
	/**
	 * 从session中取得当前登录用户的uid,作为视频的一部分信息
	 * 
	 * @param unknown_type $postData        	
	 */
	public function getAddUserId($postData) {
		$auth = new AuthenticationService ();
		$Identity = $auth->getIdentity ();
		
		$postData ['user_id'] = $Identity->id;
		
		return $postData;
	} // function getAddUserId() end
	
	/**
	 * 由学校的id 查询 市区 城市 省份的id，国家的id默认为中国的1000
	 * 
	 * @param array $data        	
	 * @return array
	 */
	public function generateVideoFilterAreaData($postData) {
		if (! isset ( $postData ['school_school_id'] )  || $postData ['school_school_id'] == '') {
			$this->ajaxReturn ( '300', '您没有选择视频所在的学校，请为视频选择一个所属的学校！' );
		}
		
		
		$schoolId = $postData ['school_school_id'];
		
		$schoolInfo = $this->areaModel->getRowById ( $schoolId, array (
				'level' 
		) );
		
		if ($schoolInfo ['level'] != 5) {
			$this->ajaxReturn ( '300', '您选择的学校信息错误，请为视频选择一个所属的学校！' );
		}
		
		$ancestorRowList = $this->areaModel->getAncestorRowListById ( $schoolId, array (
				'id',
				'level' 
		) );
		
		$ancestorRowList = ArrayKeyOperation::changeArrayKey ( $ancestorRowList, 'level' );
		
		$postData ['country_id'] = $ancestorRowList [1] ['id'];
		$postData ['province_id'] = $ancestorRowList [2] ['id'];
		$postData ['city_id'] = $ancestorRowList [3] ['id'];
		$postData ['district_id'] = $ancestorRowList [4] ['id'];
		$postData ['school_id'] = $ancestorRowList [5] ['id'];
		
		return $postData;
	}
	public function getFileName($id) {
		$file_name = 'H' . $id . '_d_000.mp4';
		return $file_name;
	}
	public function getVideoSize($VideoDiskPath) {
		return FileInfo::getFormatFilesize ( $VideoDiskPath, 'kb' );
	}
	public function getVideoLength($VideoDiskPath) {
		return VideoInfo::getLength ( $VideoDiskPath );
	}
	public function getThumbBasename($VideoDiskPath) {
		$tmp_name = strrchr ( $VideoDiskPath, '/' );
		
		return md5 ( basename ( $tmp_name ) );
	} // function getThumbBasename() end
	
	/**
	 * $source 视频文件的完整文件路径，包括文件夹和文件名
	 * $target 视频文件的截图的存放目录
	 * 
	 * @param unknown_type $source        	
	 * @param unknown_type $target        	
	 */
	public function GenerateVideoThumb($source, $target) {
		$ThumbBasename = md5 ( basename ( strrchr ( $source, '/' ) ) );
		
		$VideoDiskDirectory = dirname ( $target );
		// 从视频存放的路径获得视频存放的文件夹，就是视频完整的路径去除文件名之后得到文件夹
		
		$VideoThumbSizeArray = array (
				"640x480",
				"426x320",
				"150x113",
				"116x87",
				"64x48" 
		);
		// 从配置文件中读取到缩略图的尺寸的配置
		
		$FirstThumbSize = $VideoThumbSizeArray [0];
		// 从缩略图的尺寸中找到第一张缩略图
		
		$VideoFirstThumbPath = $VideoDiskDirectory . "/" . $ThumbBasename . "_" . $FirstThumbSize . ".jpg";
		// 第一张缩略图的路径
		
		// ------------------------------生成图像相关-------------------------------------//
		$FfmpegMovie = new \ffmpeg_movie ( $target ); // 新建ffmpeg对象
		
		$FfmpegFrame = $FfmpegMovie->getFrame ( 240 ); // 得到ffmpeg的帧对象,取第240帧
		
		$FfmpegImage = $FfmpegFrame->toGDImage (); // 把得到的帧对象转换成为图像对象
		
		imagejpeg ( $FfmpegImage, $VideoFirstThumbPath ); // 调用imagejpeg生成图像
		
		imagedestroy ( $FfmpegImage ); // 销毁图像对象，因为已经写入到文件中去了
		                            
		// ------------------------------生成各种尺寸的缩略图--------------------------/
		
		unset ( $VideoThumbSizeArray [0] ); // 删除第一张已经生成的缩略图的尺寸
		
		array_merge ( $VideoThumbSizeArray ); // 生成了第一张缩略图之后，之后都是从这张图生成缩略图，所以把数组的第一个元素给弹出来
		
		$image = new Image ();
		
		foreach ( $VideoThumbSizeArray as $VideoThumbSize ) {
			
			$widthAndHeightArray = explode ( "x", $VideoThumbSize );
			
			$newWidth = $widthAndHeightArray [0];
			
			$newHeight = $widthAndHeightArray [1];
			
			$smallImgSrc = $VideoDiskDirectory . "/" . $ThumbBasename . "_" . $VideoThumbSize . ".jpg";
			
			$image->thumb ( $VideoFirstThumbPath, $smallImgSrc, 'jpg', $newWidth, $newHeight, $interlace = true );
		} // foreach end
	}
	public function getVideoYear($data) {
		$data ['year'] = date ( "Y", time () );
		
		return $data;
	} // function getVideoYear() end
	
	/**
	 *
	 * @param array $data
	 *        	由添加界面上传的教师的名称得到JSON字符串类型的数据，跟由录播平台上传的视频保持一致
	 * @return array $data 经过处理之后的包含键值的speaker数据
	 */
	public function generateSpeakerJsonData($data) {
		$speaker = array ();
		
		$speaker ['src'] = '';
		$speaker ['name'] = $data ['speaker'] ['name'];
		$speaker ['sex'] = '';
		$speaker ['intro'] = '';
		
		$data ['speaker'] = json_encode ( $speaker );
		
		return $data;
	} // function generateSpeakerJsonData() end
	public function multiDeleteAction() {
		$request = $this->getRequest ();
		
		if (! $request->isXmlHttpRequest ()) {
			die ( '请不要尝试非法操作，谢谢您的合作！' );
		}
		
		$postData = $request->getPost ()->toArray ();
		
		$videoIdList = $postData ['ids'];
		
		// 此处开启数据事务
		$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction ();
		
		try {
			
			foreach ( $videoIdList as $videoId ) {
				
				$where = new Where ();
				$where->equalTo ( 'video_id', $videoId );
				
				$this->videoModel->deleteRowById ( $videoId );
				$this->videoFilterModel->deleteRowById ( $videoId );
				$this->videoPlayinfoModel->deleteRowById ( $videoId );
				$this->videoLabelModel->deleteRowByCondition ( $where );
			}
		} catch ( \Exception $e ) {
			
			$dbConnection->rollback ();
			$this->ajaxReturn ( '300', $e->getMessage () );
		}
		
		$dbConnection->commit ();
		$this->ajaxReturn ( '200', '恭喜您，批量删除视频成功！' );
	} // function multiDeleteAction() end
	
	
	
	public function videoCheckAction() {
		$request = $this->getRequest ();
		
		if (! $request->isXmlHttpRequest ()) {
			die ( '请不要尝试非法操作，谢谢您的合作！' );
		}
		
		$postData = $request->getPost ()->toArray ();
		
		$videoIdList = $postData ['ids'];
		
		// 此处开启数据事务
		$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction ();
		
		try {
			
			$data ['status'] = 'Y';
			foreach ( $videoIdList as $videoId ) {
				
				$this->videoModel->updateRowById ( $videoId, $data );
			}
		} catch ( \Exception $e ) {
			
			$dbConnection->rollback ();
			$this->ajaxReturn ( '300', $e->getMessage () );
		}
		
		$dbConnection->commit ();
		$this->ajaxReturn ('200','恭喜您，批量审核视频成功！');
		
		
		
		
	}
	
	public function videoUploadAction() {
		$request = $this->getRequest ();
	
		if (! $request->isXmlHttpRequest ()) {
			die ( '请不要尝试非法操作，谢谢您的合作！' );
		}
	
		$postData = $request->getPost ()->toArray ();
	
		$videoIdList = $postData ['ids'];
	
		// 此处开启数据事务
		$dbConnection = $this->getServiceLocator ()->get ( 'Zend\Db\Adapter\Connection' );
		$dbConnection->beginTransaction ();
	
		try {
				
			$data ['upload_status'] = 'enupload';
			foreach ( $videoIdList as $videoId ) {
	
				$this->videoModel->updateRowById ( $videoId, $data );
			}
		} catch ( \Exception $e ) {
				
			$dbConnection->rollback ();
			$this->ajaxReturn ( '300', $e->getMessage () );
		}
	
		$dbConnection->commit ();
		$this->ajaxReturn ('200','恭喜您，批量上传视频成功！');
	
	
	
	
	}	
	
	
	
	public function getUploadStatusString($data)
	{
		$data = get_object_vars($data);
	
		$status = $data['upload_status'];
	
		$status_string = '不能识别的状态';
	
		switch($status){
			case 'disupload':$status_string = '否';break;
			case 'uploaded':$status_string = '是';break;
			case 'enupload':$status_string = '上传中';break;
		}
	
		return $status_string;
	
	}
	
	
	
	public function getStatusString($data)
	{
		$data = get_object_vars($data);

		$status = $data['status'];
		
		$status_string = '不能识别的状态';
		
		if ($status == 'Y'){
			
			$status_string = '已审核';
			
		}elseif ($status == 'N'){
			
			$status_string = '未审核';
		}
		
		return $status_string;
		
	}		
   
}//class VideoController() end
