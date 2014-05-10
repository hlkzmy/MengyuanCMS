<?php
namespace Etah\Mvc\Model\Evaluate;

use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Adapter\Adapter;

class EvaluationCommentModel extends BaseModel
{
	protected $table = 'evaluate_evaluation_comment';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}//class ArticleModel() end