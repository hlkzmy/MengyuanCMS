<?php

namespace Cms\Component\Article\Sidebar\Category\Model;

use Application\Model\BaseModel;
use Zend\Db\Adapter\Adapter;



class ArticleCategory extends BaseModel
{
    protected $table = 'resource_article_sort';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}