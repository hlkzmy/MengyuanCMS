<?php




return array(
		
    'resource.video.create' => array(

    	'form'=>'videoForm',
    	//进行查询所对应的主表
    		
    	'columns' => array(
        //在列表中需要显示的字段

    			        'upload_flag'=>array(
    			        			'label'=>'upload_flag',
    			        			'form_control'=>'hidden',
	    			        		'attribute'=>array(
	    			        				'id'=>'upload_flag',
	    			        				)
    			        		),
    		
        		        'file'=>array(
    										'label'=>'上传视频',
    										'form_control'=>'DwzUploadify',
        		        					'attribute'=>array(
        		        								   	'id'=>'UploadButton',
					        								'swf'=>'/platform/backend/public/plugin/uploadify/scripts/uploadify.swf',
					        								'uploader'=>'/platform/backend/public/resource/video/AjaxDouploadVideo',
					        								'formData'=>'{"website":"resource.video.checkcreate","column":"upload_flag"}',
        		        									'width'=>"138px",
        		        									'height'=>"30px",
					        								'buttonClass'=>'uploadify-button',
        		        									'buttonImage'=>'/platform/backend/public/plugin/uploadify/img/add.jpg',
					        								'fileSizeLimit'=>$video_upload_max_size,
		        		        							'fileTypeDesc'=>'*.mp4;',
		        		        							'fileTypeExts'=>'*.mp4;',
// 					        								'fileTypeDesc'=>'*.mp4;*.rmvb;*.avi;*.3gp;*.wmv;',
// 					        								'fileTypeExts'=>'*.mp4;*.rmvb;*.avi;*.3gp;*.wmv;',
        		        									'onUploadError'=>'uploadifyError',
        		        									'onUploadSuccess'=>'onUploadSuccess'
        		        								)
    								),
    			
    					'name'=>array(
        		        					'label'=>'视频名称',
    										'form_control'=>'text'
        		        		   ),
        		
         				'speaker[name]'=>array(
         		        					'label'=>'主讲人',
         									'form_control'=>'text'
         		        		  	),
    			
    					'video_sort_id'=>array(
    										'label'=>'视频分类',
    										'form_control'=>'DwzLookup',
    										'attribute'=>array(
    												       		'href'=>'#',
    															'lookupgroup'=>'video',
    															'name'=>'video_sort_id',
    															'width'=>'1000',
    															'height'=>'500',
    															'label'=> '选择视频从属的分类',
    															'size'=>'40'
    													)
    								),
    			
    					'video_label_id'=>array(
    							
    										'label'=>'视频标签',
			    							'form_control'=>'MultiCheckbox',
			    							'options'=>array(
			    									'model'=>'labelModel',
			    									'field'=>array('id','name'),
			    									'function'=>'getRowList',
			    									'defaultValue'=>false,
			    							)
    							
    							),
    			
    					'school_id'=> array(
    										'label'=>'所在学校',
    										'form_control'=>'Dwzlookup',
			    							'attribute'=>array(
			    									'href'=>'#',
			    									'lookupgroup'=>'school',
			    									'name'=>'school_id',
			    									'width'=>'700',
			    									'height'=>'500',
			    									'label'=> '选择视频所属的学校',
			    									'size'=>'40'
			    							)
    								),
    			
		    			'description'=>array(
					    					'label'=>'视频描述',
		    								'form_control'=>'textarea',
		    								'attribute'=>array(
		    												'rows'=>10,
		    												'cols'=>60
		    											)
		    			            ),
    			
		    		),
    		
    		'additional_columns' => array(
    				
    				'video_sort_id'  => array( 
    											'href'=>array(
    														  'function'=>'getVideoSortIdLookupHref'
    													)
    										 ),
    				
    				'school_id'  	=> array(
    											'href'=>array(
    														  'function'=>'getSchoolIdLookupHref'
    													)
    										)
    				
    		)
    		
     ),//resource.video.create
    
	'resource.videosort.create' => array(
		
			'form'=>'videoSortForm',
			//进行查询所对应的主表
	
			'columns' => array(
					//在列表中需要显示的字段
					'parent_id'=>array(
							'label'=>'父级分类',
							'form_control'=>'Dwzlookup',
							'attribute'=>array(
									'href'=>'#',
									'lookupgroup'=>'videosort',
									'name'=>'parent_id',
									'width'=>'700',
									'height'=>'500',
									'label'=> '选择视频所从属的分类',
									'size'=>'60'
							)
					),
					
					'name'=>array(
							'label'=>'分类名称',
							'form_control'=>'text'
					),
					
					'description'=>array(
							'label'=>'分类描述',
							'form_control'=>'textarea',
							'attribute'=>array(
									'rows' =>'10',
									'cols' =>'60'
							)
					),
					
			),
			
			'additional_columns' => array(
			
					'parent_id'  => array(
										'href'=>array(
											'function'=>'getParentIdLookupHref',
										)
					 ),
					
			)
		
	),//resource.videosort.create
	'resource.videolabel.create' => array(
	
			'form'=>'videoLabelForm',
			//进行查询所对应的主表
	
			'columns' => array(
						
					'name'=>array(
							'label'=>'标签名称',
							'form_control'=>'text'
					),
						
					'description'=>array(
							'label'=>'标签描述',
							'form_control'=>'textarea',
							'attribute'=>array(
									'rows' =>'10',
									'cols' =>'60'
							)
					),
						
			),
	
	),//resource.videosort.create	
	'resource.article.create' => array(
	
			'form'=>'articleForm',
			//进行查询所对应的主表
	
			'columns' => array(
					//在列表中需要显示的字段
	
					'title'=>array(
									'label'=>'文章标题',
									'form_control'=>'text',
									'attribute'=>array(
													'size'=>40
													)
								  ),
					 
					'sub_title'=>array(
									'label'=>'文章副标题',
									'form_control'=>'text',
									'attribute'=>array(
														'size'=>40
													  )
								  ),
	
					'article_sort_id'=>array(
											'label'=>'文章分类',
											'form_control'=>'DwzLookup',
											'attribute'=>array(
													'href'=>'#',
													'lookupgroup'=>'articlesort',
													'name'=>'article_sort_id',
													'width'=>'800',
													'height'=>'500',
													'label'=> '选择文章所从属的分类',
													'size'=>'60'
											)
									),
					 
					'keyword'=>array(
											'label'=>'文章关键词',
											'form_control'=>'text',
											'attribute'=>array(
																'size'=>40
														)
									),
					 
					'content'=>array(
											'label'=>'文章内容',
											'form_control'=>'textarea',
											'attribute'=>array(
																'class'=>'editor',
																'upLinkExt'=>"zip,rar,txt",
																'upImgExt'=>"jpg,jpeg,gif,png",
																'style'=>'width:100%',
																'rows'=>30,
																'cols'=>140,
																'tools'=>	'Source,Preview,Fullscreen,SelectAll,|,'
																			.'Cut,Copy,Paste,Pastetext,|,'
																			.'Hr,Blocktag,Fontface,FontSize,FontColor,BackColor,Bold,Italic,Underline,Strikethrough,|,'
																			.'Align,Indent,Outdent,Removeformat,|,'
																			.'Img,Unlink,Link,Emot,Table'
														)
									)
			
			),
			
			
			'additional_columns' => array(
					
					'content'  => array(
										'upLinkUrl'=>array(
													'function'=>'getArticleContentUpLinkUrlString'
												),
										'upImgUrl' =>array(
													'function'=>'getArticleContentUpImgUrlString'
												)
					),
					'article_sort_id'=> array(
										'href'=>array(
													'function'=>'getArticleSortLookupHref'
												)
					),
					
						
			)
			
	
	),//resource.article.create
	
	'resource.articlesort.create' => array(
	
			'form'=>'articleSortForm',
			//进行查询所对应的主表
	
			'columns' => array(
					//在列表中需要显示的字段
					'parent_id'=>array(
							'label'=>'父级分类',
							'form_control'=>'DwzLookup',
							'attribute'=>array(
												'href'=>'#',
												'lookupgroup'=>'articlesort',
												'name'=>'parent_id',
												'width'=>'800',
												'height'=>'500',
												'label'=> '选择文章所从属的分类',
												'size'=>'60'
							)
					),
	
					'name'=>array(
							'label'=>'分类名称',
							'form_control'=>'text'
					),
	
					'description'=>array(
							'label'=>'分类描述',
							'form_control'=>'textarea',
							'attribute'=>array(
									'rows' =>'10',
									'cols' =>'80'
							)
					),
	
			),
			
			'additional_columns' => array(
					
					'parent_id'=> array(
							
							'href'=>array(
									'function'=>'getParentIdLookupHref'
									)
					),
						
			
			)
	
	),//resource.articlesort.create
	
	'resource.courseware.create' => array(
	
			'form'=>'coursewareForm',
			//进行查询所对应的主表
	
			'columns' => array(
					//在列表中需要显示的字段
								'courseware'=>array(
										'label'=>'上传课件',
										'form_control'=>'file'
								),
								 
								'name'=>array(
										'label'=>'课件名称',
										'form_control'=>'text',
										'attribute'=>array(
														'size'=>40
													)
								),
								
								'courseware_sort_id'=>array(
										'label'=>'课件分类',
										'form_control'=>'DwzLookup',
										'attribute'=>array(
												'href'=>'#',
												'lookupgroup'=>'coursewaresort',
												'name'=>'courseware_sort_id',
												'width'=>'800',
												'height'=>'500',
												'label'=> '选择课件所从属的分类',
												'size'=>'40'
										)
								),

								'video_id'=>array(
										'label'=>'所属视频',
										'form_control'=>'DwzLookup',
										'attribute'=>array(
												'href'=>'#',
												'lookupgroup'=>'video',
												'name'=>'video_id',
												'width'=>'800',
												'height'=>'500',
												'label'=> '选择课件所从属的视频',
												'size'=>'40'
										)
								),
								 
								'description'=>array(
										'label'=>'课件描述',
										'form_control'=>'textarea',
										'attribute'=>array(
												'rows'=>10,
												'cols'=>60
										)
								),
					
					
					
					 
			),
			'additional_columns' => array(
						
					'courseware_sort_id'=> array(
							
							'href'=>array(
									'function'=>'getCoursewareSortIdLookupHref'
							)
					),
					
					'video_id'=> array(
								
							'href'=>array(
									'function'=>'getVideoIdLookupHref'
							)
					),
			)
	
	),//resource.courseware.create
	
	'resource.coursewaresort.create' => array(
	
			'form'=>'coursewareSortForm',
			//进行查询所对应的主表
	
			'columns' => array(
					//在列表中需要显示的字段
					'parent_id'=>array(
							'label'=>'父级分类',
							'form_control'=>'DwzLookup',
							'attribute'=>array(
									'href'=>'#',
									'lookupgroup'=>'coursewaresort',
									'name'=>'parent_id',
									'width'=>'800',
									'height'=>'500',
									'label'=> '选择课件所从属的分类',
									'size'=>'20'
							)
					),
					'name'=>array(
							'label'=>'分类名称',
							'form_control'=>'text'
					),
	
					'description'=>array(
							'label'=>'分类描述',
							'form_control'=>'textarea',
							'attribute'=>array(
									'rows' =>'10',
									'cols' =>'80'
							)
					),
	
			),
			
			'additional_columns' => array(
						
					'parent_id'=> array(
								
							'href'=>array(
										'function'=>'getParentIdLookupHref'
									
									)
					),
			)
	
	),//resource.coursewaresort.create
	
	
    
        
    
);
