<?php
namespace Etah\Mvc\Model\Evaluate;

use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Adapter\Adapter;


class EvaluationModel extends BaseModel
{
    protected $table = 'evaluate_evaluation';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * 根据所要取得的条数获得我的评论列表
     * 默认未开始和进行中全部显示,已结束的条数根据参数计算
     * @param int $num
     * @return array
     */
    public function getEvaluationList($uid=NULL,$idArr=NULL,$num=NULL){
    	
    	$num = (int)$num ? (int)$num : 10;
    	$select = $this->getSql()->select();
    	$evaluationColumns = array('id','name','start_time','end_time','video_id','course_description','teach_purpose');
    	$select->columns($evaluationColumns);
    	$whereID = new Where();
   		 if(isset($uid)){
    		$whereID->equalTo('evaluated_user_id',$uid);
    	}
    	if(is_array($idArr)){
    		$orWhere = new Where(array($whereID),'OR');
    		if(count($idArr) > 0){
    			$orWhere -> in('id',$idArr);
    		}
    	}
    	$select->where($whereID);
    	$select->limit($num);
    	$select->order(array('end_time'=>'desc'));
    	
    	$EvaluationList = $this->selectWith($select)->toArray();
    	$gStart = array();
    	$isStart= array();
    	$end = array();
    	$date = date('Y-m-d H:i:s');
	    foreach ($EvaluationList as $info){
	    	if ($info['start_time'] > $date){
	    		array_push($gStart, $info);
	    	}elseif ($info['end_time'] < $date){
	    		array_push($end, $info);
	    	}elseif ($info['end_time'] > $date && $info['start_time'] < $date){
	    		array_push($isStart, $info);
	    	}
	    }
    	$allMesArr = array('未开始'=>$gStart,'进行中'=>$isStart,'已完成'=>$end);
    	return $allMesArr;    	
    }
    
    
    
    
    
    
}//class ArticleModel() end