<?php

namespace Cms\Component\Article\Column\Model;

use Application\Model\BaseModel;
use Zend\Db\Adapter\Adapter;



class ArticleCategory extends BaseModel
{
    protected $table = 'resource_article_category';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    
}