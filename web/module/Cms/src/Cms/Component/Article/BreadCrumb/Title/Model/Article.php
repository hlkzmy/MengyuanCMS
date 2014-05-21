<?php

namespace Cms\Component\Article\BreadCrumb\Title\Model;

use Application\Model\BaseModel;
use Zend\Db\Adapter\Adapter;



class Article extends BaseModel
{
    protected $table = 'resource_article';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}