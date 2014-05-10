<?php

namespace Etah\Common\Stylesheet;

class Stylesheet
{
	
	/**
	 * 根据路由信息得到布局容器CSS样式表所在的路径
	 * @return array $path  一个硬盘路径  一个http的路径
	 */
	 public static function getLayoutStylesheetPath($routeParameter){
	
	 	$namespace	= $routeParameter['namespace'];
	 	
	 	$controller = $routeParameter['controller'];
			
		$action 	= $routeParameter['action'];
			
		$diskPath = sprintf('%s/public/theme/%s/%s/%s/%s',BASEPATH,$namespace,$controller,$action,'layout.css');
			
		$diskPath =  str_replace("\\", '/', $diskPath) ;
			
		$httpPath = sprintf('/theme/%s/%s/%s/%s',$namespace,$controller,$action,'layout.css');
			
		$result = array();
		$result['http'] = $httpPath;
		$result['disk'] = $diskPath;
			
		return $result;
			
	}//function getLayoutStylesheetPath() end
	 
	 /**
	 * 解析CSS属性数组，拼接CSS样式的字符串
	 * $param  array  $css
	 * @return string $string
	 */
	public static function parseStylesheet($containerId,$css){
	
		$string = '#'.$containerId."{\r\n";
			
		foreach($css as $key=>$value){
			$string.= sprintf('%s:%s;%s', $key,$value,"\r\n");
		}
		 
		$string .= "}\r\n";
	
		return $string;
			
	}//function parseStylesheet() end
	
	/**
	 * 根据在数据库中的CSS样式的配置生成CSS文件
	 */
	public static function generateStylesheetFile($path,$list){
	
		if(file_exists($path)){
			//return;
		}
		 
		$totalCssString = '';
		 
		foreach($list as $key=>$container){
	
			if(!isset($container['css'])) continue;
	
			$css = unserialize($container['css']);
	
			$containerId = $container['name'];
	
			$cssString = self::parseStylesheet($containerId,$css);
	
			$totalCssString.=$cssString;
		}//foreach end
		 
		file_put_contents($path, $totalCssString);
		 
	}//function connactStylesheetString() end
	
	
	
    
    
    
}
