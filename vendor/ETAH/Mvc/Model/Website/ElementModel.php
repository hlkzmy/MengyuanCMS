<?php
namespace Etah\Mvc\Model\Website;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class ElementModel extends BaseModel
{
    protected $table = 'website_element';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }//function __construct() end
    
    
    
    
    
    
}//class VideoModel() end