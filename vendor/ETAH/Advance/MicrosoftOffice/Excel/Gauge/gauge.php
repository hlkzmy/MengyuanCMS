<?php
namespace Etah\Advance\MicrosoftOffice\Excel\Gauge;

use Etah\Advance\MicrosoftOffice\Excel\Excel;
use Etah\Common\ArrayOperation\Key as ArrayKeyOperation;


class Gauge extends Excel{
	
	  /**
	   * 默认的把Excel数据表中数据 保存成为数据库中可以存储的字符串的方式，是使用PHP的哪个函数进行
	   * @var unknown_type
	   */
	  private $databaseStoreFunction = 'json_encode';
	  
	  
	  /**
	   * 设置数据保存的方式
	   * @param string $functionName;
	   */
	  
	  public function setDatabaseStoreFunction($functionName){

	  	if(in_array(strtolower($functionName),array('json_encode','serialize' ))){
	  		$this->databaseStoreFunction = $functionName;
	  	}
	  	
	  }//function setDatabaseStoreFunction() end
	  
	  
	  /**
	   * 传递一个量规表的文件路径，包括2003和2007的格式，然后返回可以存储到数据库中量规表的数据内容字符串
	   * 包含每个单元格的格式  和 单元格的内容，是自解析的格式
	   * @param  string $filepath
	   * @return string $GaugeContentString
	   */
	  
	  public function getGaugeContentString($filepath){
	  	
	  	 $currentActiveSheet  = $this->getCurrentActiveSheet($filepath);
	  	
	  	 $complexCellInfoList = $this->getComplexCellInfoList($currentActiveSheet);
	  	 
	  	 $normalCellInfoList  = $this->getNormalCellInfoList($currentActiveSheet);
	  	
	  	 $totalCellInfoList   = array_merge($complexCellInfoList,$normalCellInfoList);
	  	 
	  	 $totalCellAddressList = array_keys($totalCellInfoList);
	  	 
	  	 $cellAddressList = $currentActiveSheet->getCellCollection();
	  	 
	  	 $gaugeContentArray = array();
	  	 
	  	 foreach($cellAddressList as $address){

	  	 	if(in_array($address,$totalCellAddressList)){
	  	 		array_push($gaugeContentArray,$totalCellInfoList[$address]);
	  	 	}
	  	 	
	  	 }//foreach end
	  	 return call_user_func( $this->databaseStoreFunction , $gaugeContentArray);
	  	 
	  }//function getGaugeContentString() end
	  
	  
	  /**
	   * 传递一个量规表的经过getGaugeContentString放
	   * 包含每个单元格的格式  和 单元格的内容，是自解析的格式
	   * @param  string $filepath
	   * @return string $GaugeContentString
	   */
	  
	  public static function getTemplateHtmlArray($templateContent) {
	  
	  		$templateContent = json_decode($templateContent,true);
	  	
	  		$templateHtmlArray = array ();
		  
		  	$reg = '/\d+/';
		  
		  	foreach ( $templateContent as $cell ) {
		  			
		  		$address = $cell ['address'];
		  			
		  		preg_match_all ( $reg, $address, $row );
		  			
		  		$row = $row[0][0];
		  			
		  		if (! array_key_exists($row, $templateHtmlArray)) {
		  
		  			$templateHtmlArray [$row] = array ();
		  
		  		}
		  			
		  		array_push ( $templateHtmlArray [$row], $cell );
		  		
		  	}//foreach end
		  
		  	return $templateHtmlArray;
	  
	  }//function ReturntemplateHtmlArray() end
	
		
	
	
	
	
	
	
	
	
	
	
}