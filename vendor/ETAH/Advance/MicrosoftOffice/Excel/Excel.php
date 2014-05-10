<?php
namespace Etah\Advance\MicrosoftOffice\Excel;

use Org\PHPExcel\Reader\Excel2007 as Excel2007Reader;
use Org\PHPExcel\Reader\Excel5    as Excel2003Reader;




class Excel{
	
	protected $cellDefaultWidth  = 72;
	//单元格的默认宽度，单位为像素
	
	protected $cellDefaultHeight = 18;
	//单元格的默认高度，单位为像素
	
	
	
	/**
	 * 通过excel的文件信息，来返回适合当前文件的reader
	 * 1.根据后缀名，不能防范修改后缀名之后的修改
	 * 2.根据文件的MIME类型，一定程序上可以防范修改后缀名或者修改文件内容的问题
	 * @todo 改成使用MIME类型判断Excel类型的数据
	 */
	protected function getExcelReader($filepath){
		
		if(!file_exists($filepath)){
			die('指定的Excel文件的路径在文件系统上不存在，请检查！');
		}
		
		$pathinfo      = pathinfo($filepath);
		$extensionName = strtolower($pathinfo['extension']);
		
		if(strtolower($extensionName)=='xls'){
			$phpExcelReader = new Excel2003Reader($filepath);
		}
		else if(strtolower($extensionName)=='xlsx'){
			$phpExcelReader = new Excel2007Reader($filepath);
		}
		else{
			die("在解析excel文件的时候发生了错误，错误的excel文件后缀");
		}
		
		$excelReader = $phpExcelReader->load($filepath);
		
		return $excelReader;
		
	}//function getExcelReader() end
	
	
	/**
	 * 传递一个excel文件，然后返回当前excel文件的处于活动状态的数据表
	 * @param unknown_type $filepath
	 * @return \Org\PHPExcel\Worksheet
	 */
	protected function getCurrentActiveSheet($filepath){
	
		$reader = $this->getExcelReader($filepath);
	
		$CurrentActiveSheet = $reader->getActiveSheet();
		//得到处于激活状态的分表
		
		return $CurrentActiveSheet;
		
	}//function ReturnCurrentActiveSheet() end
	
	
	/**
	 * 传递一个excel中数据表，然后返回当前处于正常状态的单元格的地址列表
	 * @param ActiveSheet $currentActiveSheet
	 */
	
	protected function getNormalCellAddressList($currentActiveSheet){
		
		$cellAddressList = $currentActiveSheet->getCellCollection();
		//得到所有单元格地址的列表
		
		$mergedAddressList = $this->getMergedCellAddressList($currentActiveSheet);
		
		$complexAddressList = $this->getComplexCellAddressList($currentActiveSheet);
		
		$normalAddressList = array_diff($cellAddressList, $mergedAddressList,$complexAddressList);
		
		return $normalAddressList;
		
	}//function getNormalCellList() end
	
	
	/**
	 * 传递一个excel中数据表，然后返回当前处于复杂状态的单元格的地址列表
	 * 所谓的复杂单元格就是一个单元格合并了若干的单元格
	 * @param ActiveSheet $currentActiveSheet
	 */
	
	protected function getComplexCellAddressList($currentActiveSheet){
	
		$mergedCellRangeAddressList = $currentActiveSheet->getMergeCells();
		//因为得到的地址不是简单的地址，而是一个起始地址 ：结束地址的单元格
		
		$complexCellAddressList = array();
		
		foreach($mergedCellRangeAddressList as $MergedCellAddress){
		
			$rangeAddressList = $currentActiveSheet->getCell("A1")->extractAllCellReferencesInRange($MergedCellAddress);
				
			array_push($complexCellAddressList, array_shift($rangeAddressList));
		}
		
		return $complexCellAddressList;
	
	}//function getNormalCellList() end
	
	/**
	 * 传递一个excel中数据表，然后返回当前处于被合并状态的单元格的地址
	 * 但是这个地址是一个符合地址，由 起始地址 和 终止地址 加冒号组成
	 * @param ActiveSheet $currentActiveSheet
	 */
	protected function getMergedCellAddressList($currentActiveSheet){
	
		$mergedCellRangeAddressList = $currentActiveSheet->getMergeCells();
		//因为得到的地址不是简单的地址，而是一个起始地址 ：结束地址的单元格
		
		$mergedCellAddressList = array();
		
		foreach($mergedCellRangeAddressList as $MergedCellAddress){
				
			$rangeAddressList = $currentActiveSheet->getCell("A1")->extractAllCellReferencesInRange($MergedCellAddress);
				
			array_shift($rangeAddressList);
				
			$mergedCellAddressList = array_merge($mergedCellAddressList,$rangeAddressList);
		}
		
		return $mergedCellAddressList;
	}//function getNormalCellList() end
	
	
	/**
	 * 传递一个excel中数据表，然后返回当前处于正常状态的单元格的信息
	 * 包括以下的指标
	 * address 地址  A1 还是 A2
	 * colspan 横向占用几个单元格   对于正常的单元格 恒定为1
	 * rowspan 竖向占用几个单元格   对于正常的单元格 恒定为1
	 * width   单元格的宽度
	 * height  单元格的高度
	 * content 单元格的内容
	 */
	protected function getNormalCellInfoList($currentActiveSheet){
		
		$cellAddressList = $this->getNormalCellAddressList($currentActiveSheet);
		
		if(sizeof($cellAddressList)<=0){
			return array();
		}
		
		$cellInfoList = array();
		
		foreach($cellAddressList as $cellAddress){
			
			$temp = array();
			$temp['address'] 	= $cellAddress;
			$temp['rowspan'] 	= 1;
			$temp['colspan'] 	= 1;
			$temp['width'] 		= $this->getNormalCellWidth($currentActiveSheet, $cellAddress);
			$temp['height'] 	= $this->getNormalCellHeight($currentActiveSheet, $cellAddress);
			$temp['content']	= $this->returnCellContent($currentActiveSheet, $cellAddress);
			$temp['type'] 		= 'normal';
			
			$cellInfoList[$cellAddress] = $temp;
			
		}//foreach end
		
		return $cellInfoList;
	
	}//function getNormalCellInfoList() end
	
	/**
	 * 传递一个excel中数据表，然后返回当前处于被合并状态的单元格的信息
	 * 包括以下的指标
	 * address 地址  A1 还是 A2
	 * colspan 横向占用几个单元格   对于被合并的单元格 恒定为0
	 * rowspan 竖向占用几个单元格   对于被合并的单元格 恒定为0
	 * width   单元格的宽度 		对于被合并的单元格 恒定为0
	 * height  单元格的高度		对于被合并的单元格 恒定为0
	 * content 单元格的内容		对于被合并的单元格 恒定为null
	 */
	protected function getMergedCellInfoList($currentActiveSheet){
		
		$cellAddressList = $this->getMergedCellAddressList($currentActiveSheet);
		
		if(sizeof($cellAddressList)<=0){
			return array();
		}
		
		$cellInfoList = array();
		
		foreach($cellAddressList as $cellAddress){
			
			$temp = array();
			$temp['address'] = $cellAddress;
			$temp['rowspan'] = 0;
			$temp['colspan'] = 0;
			$temp['width'] = 0;
			$temp['height'] = 0;
			$temp['content'] = NULL;
			$temp['type'] = 'merged';
			
			$cellInfoList[$cellAddress] = $temp;
			
		}//foreach end
		
		return $cellInfoList;
		
	}//function getMergedCellInfoList() end
	
	
	
	/**
	 * 传递一个excel中数据表，然后返回当前处于复杂状态的单元格的信息
	 * 包括以下的指标
	 * address 地址  A1 还是 A2
	 * colspan 横向占用几个单元格  
	 * rowspan 竖向占用几个单元格 
	 * width   单元格的宽度
	 * height  单元格的高度
	 * content 单元格的内容
	 */
	
	protected function getComplexCellInfoList($currentActiveSheet){
	
		$cellAddressList = $currentActiveSheet->getMergeCells();
		
		if(sizeof($cellAddressList)<=0){
			return array();
		}
	
		$cellInfoList = array();
	
		foreach($cellAddressList as $cellAddress){
				
			$range = $currentActiveSheet->getCell("A1")->getRangeBoundaries($cellAddress);
			
			$colspan= ord($range[1][0]) - ord($range[0][0])+1;
			
			$rowspan= $range[1][1] - $range[0][1]+1;
			
			$startCell = substr($cellAddress,0,strpos($cellAddress, ':') );
			
			$temp = array();
			$temp['address'] = $startCell;
			$temp['rowspan'] = $rowspan;
			$temp['colspan'] = $colspan;
			$temp['width']   = $this->getComplexCellWidth($currentActiveSheet, $startCell, $colspan);
			$temp['height']  = $this->getComplexCellHeight($currentActiveSheet,$startCell, $rowspan);
			$temp['content'] = $this->returnCellContent($currentActiveSheet, $startCell);
			$temp['type'] = 'complex';
				
			$cellInfoList[$startCell] = $temp;
				
		}//foreach end
		return $cellInfoList;
	
	}//function getMergedCellInfoList() end
	
	/**
	 * 返回单元格内容
	 * @param activeSheet $CurrentActiveSheet
	 * @param string $address
	 * @return string $content
	 */
	private function returnCellContent($currentActiveSheet,$address){
	
		$content = $currentActiveSheet->getCell($address)->getFormattedValue();
	
		return $content;
	}//function ReturnCellContent() end
	
	
	/**
	 * 传递一个excel中数据表，然后一个普通单元格的宽度
	 * @param activeSheet $currentActiveSheet
	 * @param string $address
	 * @return int $width
	 */
	
	protected function getNormalCellWidth($currentActiveSheet,$address){
	
		$column = $currentActiveSheet->getCell($address)->getColumn();
		
		$width = $currentActiveSheet->getColumnDimension()->getWidth($column);
		
		$width = $width>0?round($width*8):$this->cellDefaultWidth;
		
		return $width;
	}
	
	/**
	 * 传递一个excel中数据表，然后一个普通单元格的高度
	 * @param activeSheet $currentActiveSheet
	 * @param string $address
	 * @return int $width
	 */
	
	protected function getNormalCellHeight($currentActiveSheet,$address){
	
		$row 	= $currentActiveSheet->getCell($address)->getRow();
		
		$height = $currentActiveSheet->getRowDimension()->getRowHeight($row);
		
		$height = $height>0?round($height/0.75):$this->cellDefaultHeight;
		
		return $height;
	}
	
	/**
	 * 传递一个excel中数据表，然后一个复杂单元格的宽度
	 * @param activeSheet $currentActiveSheet
	 * @param string $address
	 * @return int $width
	 */
	
	protected function getComplexCellWidth($currentActiveSheet,$address,$colspan){
	
		if ($colspan > 1){
		
			$complicatedWidth = 0;
			
			$Column = $currentActiveSheet->getCell($address)->getColumn();
			
			for (;$colspan>=1;$colspan--){
				
				$width = $currentActiveSheet->getColumnDimension($Column)->getWidth();
				
				$width = $width>0?round($width*8):$this->cellDefaultWidth;
				
				$complicatedWidth += $width;
				
				$Column = chr(ord($Column)+1);
				
			}
			
			return $complicatedWidth;
		}
		else{
		
			return $this->getNormalCellWidth($currentActiveSheet, $address);
		}
	
	}//protected function ReturnComplexCellWidth() end
	
	
	/**
	 * 传递一个excel中数据表，然后一个复杂单元格的高度
	 * @param activeSheet $currentActiveSheet
	 * @param string $address
	 * @return int $width
	 */
	protected function getComplexCellHeight($currentActiveSheet, $address, $rowspan){
	

		
		if($rowspan >1 )
		{
			$complicatedHeight = 0;
			
			$Row = $currentActiveSheet->getCell($address)->getRow();
			
			for (;$rowspan>=1;$rowspan--){
				
				$Height =$currentActiveSheet->getRowDimension($Row++)->getRowHeight();
				
				$Height = $Height>0?round($Height/0.75):$this->cellDefaultHeight;
				
				$complicatedHeight += $Height;
				
			}
			
// 			echo 'address:';print_r($address); echo 'rowspan:';print_r($rowspan);echo ' h:';print_r($complicatedHeight); echo '<br />';
			return $complicatedHeight;
			
		}
		else{
			
			return $this->getNormalCellHeight($currentActiveSheet, $address);
			
		}
	
	}//protected function ReturnComplicatedHeight() end
	

	
	
	
	
	
	
	
	
	
	
}