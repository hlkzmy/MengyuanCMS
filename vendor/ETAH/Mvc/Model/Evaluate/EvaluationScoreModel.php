<?php
namespace Etah\Mvc\Model\Evaluate;

use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Adapter\Adapter;


class EvaluationScoreModel extends BaseModel
{
	protected $table = 'evaluate_evaluation_score';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}//class ArticleModel() end