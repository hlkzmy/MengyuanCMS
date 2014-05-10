<?php
namespace Etah\Mvc\Model\System;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class RoleModel extends BaseModel
{
    protected $table = 'system_role';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}//class SchoolModel() end