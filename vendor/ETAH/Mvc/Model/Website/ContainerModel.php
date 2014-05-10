<?php

namespace Etah\Mvc\Model\Website;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;


class ContainerModel extends BaseModel
{
	
	protected $table = 'website_container';
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
   
   
    
}