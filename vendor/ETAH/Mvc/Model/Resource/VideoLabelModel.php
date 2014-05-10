<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;



class VideoLabelModel extends BaseModel
{
	
	protected $table = 'resource_video_label';
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
   
   
    
}