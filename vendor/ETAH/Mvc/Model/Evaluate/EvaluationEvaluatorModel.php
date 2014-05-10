<?php

namespace Etah\Mvc\Model\Evaluate;

use Etah\Mvc\Model\BaseModel;
use Zend\Db\Adapter\Adapter;

class EvaluationEvaluatorModel extends BaseModel
{
    protected $table = 'evaluate_evaluation_evaluator';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
}