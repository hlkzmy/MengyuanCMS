<?php
namespace Etah\Mvc\Model\Information;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class UserRoleModel extends BaseModel
{
    protected $table = 'information_user_role';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}//class SchoolModel() end