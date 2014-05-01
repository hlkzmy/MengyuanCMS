<?php
namespace Video\Controller;

use Base\Controller\BaseController;
use Zend\View\Model\ViewModel;

use Etah\Common\String\Sub;

class VideoLabelController extends BaseController
{
	
	public function __construct(){
		
		parent::__construct();
		
		//注册数据表对象
		
		$this->registDatabaseModel($this->serviceManager,'Base','Model','LabelModel');
		$this->registDatabaseModel($this->serviceManager,'Base','Model','VideoLabelModel');
		
		//注册表单对象
		$this->registForm($this->serviceManager,'Resource','Video','VideoLabelForm');
		
		//注册Filter对象
		$this->registFilter($this->serviceManager, 'LabelFilter');
		
	}//function __construct() end
	
	
	
	public function initDataAction()
	{
		$str = 'a阿女啊二手房和反光板率空间站看到的反光镜盘带上人感觉们才能满看的空间双刃剑款新车吗';
		
		for ($a=0;$a<7;$a++){
		
			$id = $this->videoLabelModel->getLastInsertValue();
			
			$id++;
			
			$rand = rand(0, strlen($str)-5);
			
			$input  = sub::iconvSubString($str,$rand , 5,'utf-8', '.');
			
			$data = array(
					
					'name'=>'标签'.$id,
					'description'=>$input,
					
					);
			
			$this->videoLabelModel->insertRow($data);
		
		}
		
	}
	
    
}//class VideoSortController end
