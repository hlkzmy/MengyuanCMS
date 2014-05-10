<?php
namespace Etah\Mvc\Model\Common;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class TestModel extends BaseModel
{
    protected $table = 'test';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
}//class LiveClassroomModel() end