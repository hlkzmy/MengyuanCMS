<?php

namespace Etah\Mvc\Model\Website;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class PageModel extends BaseModel
{
	
	protected $table = 'website_page';
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
   
   
    
}