<?php
namespace Etah\Mvc\Model\Information;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class ClassroomStreamModel extends BaseModel
{
    protected $table = 'information_classroom_stream';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
    
    
}//class ClassroomModel() end