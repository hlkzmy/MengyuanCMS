<?php

namespace Cms\Component\Article\Column\Model;

use Application\Model\BaseModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Where;


class Article extends BaseModel
{
    protected $table = 'resource_article';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * @param  $categoryId
     */
    
    public function getArticleList($categoryId,array $column){
    	
    	$where = new Where();
    	$where->equalTo('article_category_id', $categoryId);
    	return $this->getRowByCondition($where,$column);
    	
    }
    
    
    
   
}