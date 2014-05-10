<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Sql\Where;
use Zend\Db\Adapter\Adapter;

use Etah\Mvc\Model\BaseModel;

class VideoFilterModel extends BaseModel
{
    protected $table = 'resource_video_filter';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
    
    
    
    
}//class VideoModel() end