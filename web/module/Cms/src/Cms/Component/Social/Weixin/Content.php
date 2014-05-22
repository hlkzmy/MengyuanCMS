<?php

namespace Cms\Component\Social\Weixin;
use Cms\Component\BaseComponent;
use Cms\Component\ComponentInterface;


class Content extends BaseComponent implements ComponentInterface{
	
	protected $qrCodeBasePath  = 'theme/default/common/weixin';//图片的基准路径
	
	protected $qrCodeImageName = 'qrcode.jpg';//二维码图片的名称
	
	function __construct($serviceManager){
		parent::__construct($serviceManager);
		$this->setTemplateStyle(1);
	}//function __construct() end
	
	
	
	/**
	 * 
	 * @param string $path
	 * @return \Cms\Component\Slide\Javascript\Content
	 */
	public function setQrCodeBasePath($path){
		$this->qrCodeBasePath = $path;
		return $this;
	}
	
	/**
	 *
	 * @param string $path
	 * @return \Cms\Component\Slide\Javascript\Content
	 */
	public function setQrCodeImageName($name){
		$this->qrCodeImageName = $name;
		return $this;
	}
	
	
	/**
	 * 查询数据，渲染模板
	 */
	public function componentRender($returnType='ViewModel'){
		
		//1. 得到基础路径的视图助手，从而得到完整的http绝对路径
		$basePathViewHelper = $this->serviceManager->get('View\Helper\Manager')->get('basepath');
		
		//2.得到phpRenderer对象，从而附加css js
		$phpRenderer = $this->serviceManager->get('Zend\View\Renderer\PhpRenderer');
		$phpRenderer->headLink()->appendStylesheet($basePathViewHelper('plugin/bootstrap/bootstrap.min.css'))
								->appendStylesheet($basePathViewHelper('component/social/weixin/images/component.css'));
		$phpRenderer->headScript()->appendFile($basePathViewHelper('plugin/bootstrap/bootstrap.min.js'));

		
		//3.拼接二维码的地址
		$qrCodePath = sprintf("%s/%s",$this->qrCodeBasePath,$this->qrCodeImageName);
		$this->setVariable('qrCodePath', $qrCodePath);
		
	}//function render() end
	
	
	
	
	
	
	
	
}//class end



