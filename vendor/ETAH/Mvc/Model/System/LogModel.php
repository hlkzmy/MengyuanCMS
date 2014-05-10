<?php
namespace Etah\Mvc\Model\System;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class LogModel extends BaseModel
{
    protected $table = 'system_log';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}//class SchoolModel() end