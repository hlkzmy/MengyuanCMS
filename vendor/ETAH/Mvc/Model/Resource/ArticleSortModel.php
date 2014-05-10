<?php
namespace Etah\Mvc\Model\Resource;

use Zend\Db\Adapter\Adapter;
use Etah\Mvc\Model\BaseModel;

class ArticleSortModel extends BaseModel
{
	
	protected $table = 'resource_article_sort';
	
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
   
   
    
}