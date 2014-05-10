<?php

return array(
		
    
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
	
	
	
	
	
);
