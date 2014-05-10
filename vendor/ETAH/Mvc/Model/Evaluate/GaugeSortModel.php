<?php
namespace Etah\Mvc\Model\Evaluate;

use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;
use Zend\Db\Adapter\Adapter;

class GaugeSortModel extends BaseModel
{
    protected $table = 'evaluate_gauge_sort';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}//class SchoolModel() end