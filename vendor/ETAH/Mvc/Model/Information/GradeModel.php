<?php
namespace Etah\Mvc\Model\Information;

use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Where;
use Etah\Mvc\Model\BaseModel;

class GradeModel extends BaseModel
{
    protected $table = 'information_grade';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
}