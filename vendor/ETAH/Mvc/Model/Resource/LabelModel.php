<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;



class LabelModel extends BaseModel
{
	
	protected $table = 'resource_label';
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
   
   
    
}