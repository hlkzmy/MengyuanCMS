<?php
namespace Etah\Mvc\Model\Information;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class ClassroomModel extends BaseModel
{
    protected $table = 'information_classroom';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
    
    
}//class ClassroomModel() end