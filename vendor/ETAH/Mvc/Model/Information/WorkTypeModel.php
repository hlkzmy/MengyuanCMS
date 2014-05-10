<?php
namespace Etah\Mvc\Model\Information;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class WorkTypeModel extends BaseModel
{
    protected $table = 'information_work_type';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
    
    
}//class SchoolModel() end