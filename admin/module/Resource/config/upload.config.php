<?php


return array(	
		'resource.video.upload' => array(
			'resource.video.checkcreate' => array(
				'upload_flag'=>array(
						
						
					'type'=>'byflash',//bypost
					'filename'=>'filename',
					'columns'=>array(
							
							/*
							 * 此处的prepose 指的是前置的操作，前置是指在插入数据之前
							* 所有前置操作结束后，会将所有函数的返回值压入uploadInfo数组以便插入数据时使用
							* 如果你需要把某些返回值存入数据库，请将这个函数设置在前置区。
							* 前置操作会默认把临时文件的路径传进去。
							* 临时文件路径有两种可能，如果是byflash，那么临时文件路径为一个设定好的全局常量+临时文件名，
							* 如果是bypost，临时文件路径为file['tmp_name']
							* 
							* 
							* 此处的midmay 指的是中间的操作， 中间操作是指在插入主表数据之后
							* midway函数中的参数是主表插入后的主键，通常是id
							* 
							*
							* 此处的postposition 指的是后置操作，后置是指插入数据之后，也在数据善后处理之后，
							* 注意：后置操作在文件移动之后
							* 但是在事务结束之前。后置操作包括产生缩略图等，会默认将文件移动后的路径传进去。
							*
							*
							*/
							'filename'=>array(
									'midway'=>'getFileName',
									
							),
							'size'=>array(
									'prepose'=>'getVideoSize',
							),
								
							'length'=>array(
									'prepose'=>'getVideoLength',
							),
							'ThumbBasename'=>array(
									'overwrite'=>array('jpg'),
									'prepose'=>'getThumbBasename',
									'postposition'=>'GenerateVideoThumb',
							),
						
						),
					'target'=>VIDEO_DISK_PATH,//此处填的都应该是全局的常量
					
					'Validator'=>array(
							
							'ext'=>array('mp4'),
							'size'=>$video_upload_max_size,
							
							),
// 					'translate'=>array(
								
// 							'function'=>'asynchronous'
			
// 					)
						
					),//end of upload_flag
					
					

					
					
					
				),
			'resource.video.checkupdate' => array(
						'upload_flag'=>array(
								'allowEmpty'=>true,
								'filename'=>'filename',
								'type'=>'byflash',//bypost
								'columns'=>array(
											
										/*
										 * 此处的prepose 指的是前置的操作，前置是指在插入数据之前
				* 所有前置操作结束后，会将所有函数的返回值压入uploadInfo数组以便插入数据时使用
				* 如果你需要把某些返回值存入数据库，请将这个函数设置在前置区。
				* 前置操作会默认把临时文件的路径传进去。
				* 临时文件路径有两种可能，如果是byflash，那么临时文件路径为一个设定好的全局常量+临时文件名，
				* 如果是bypost，临时文件路径为file['tmp_name']
				*
				*
				* 此处的midmay 指的是中间的操作， 中间操作是指在插入主表数据之后
				* midway函数中的参数是主表插入后的主键，通常是id
				*
				*
				* 此处的postposition 指的是后置操作，后置是指插入数据之后，也在数据善后处理之后，
				* 注意：后置操作在文件移动之后
				* 但是在事务结束之前。后置操作包括产生缩略图等，会默认将文件移动后的路径传进去。
				*
				*
				*/
										'filename'=>array(
												'midway'=>'getFileName',
													
										),
										'size'=>array(
												'prepose'=>'getVideoSize',
										),
				
										'length'=>array(
												'prepose'=>'getVideoLength',
										),
										'ThumbBasename'=>array(
												'prepose'=>'getThumbBasename',
												'postposition'=>'GenerateVideoThumb',
										),
				
								),
								'target'=>VIDEO_DISK_PATH,//此处填的都应该是全局的常量
									
								'Validator'=>array(
											
										'ext'=>array('mp4'),
										'size'=>$video_upload_max_size,
											
								),
								'translate'=>array(
								
										'function'=>'asynchronous'
		
								)
				
						),//end of upload_flag
							
							
							
				),
				
		),
		
		'resource.courseware.upload' => array(
				
				'resource.courseware.checkcreate' => array(
						'courseware'=>array(
								
								'filename'=>'hash',
								'type'=>'bypost',//bypost
								'columns'=>array(
										
										'hash'=>array(
												'prepose'=>'getFileName',
													
										),
										
								),
								'target'=>COURSEWARE_DISK_PATH,//此处填的都应该是全局的常量
									
								'Validator'=>array(
											
										'ext'=>array('ppt','pptx','doc','docx','xls','xlsx','pdf'),
										'size'=>$courseware_upload_max_size,
											
								)
		
						),//end of upload_flag
							
							
						
				),
				'resource.courseware.checkupdate' => array(
						'courseware'=>array(
								'allowEmpty'=>true,
								'filename'=>'hash',
								'type'=>'bypost',//bypost
								'columns'=>array(
				
										'hash'=>array(
												'prepose'=>'getFileName',
													
										),
				
								),
								'target'=>COURSEWARE_DISK_PATH,//此处填的都应该是全局的常量
									
								'Validator'=>array(
											
										'ext'=>array('ppt','pptx','doc','docx','xls','xlsx','pdf'),
										'size'=>$courseware_upload_max_size,
											
								)
				
						),//end of upload_flag
								
								
				
				),
		
		),

);