<?php
namespace Etah\Mvc\Model\Common;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class LiveClassroomModel extends BaseModel
{
    protected $table = 'common_live_classroom';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
    
    
}//class LiveClassroomModel() end