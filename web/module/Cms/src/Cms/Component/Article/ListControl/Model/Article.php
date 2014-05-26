<?php

namespace Cms\Component\Article\ListControl\Model;

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
    	$where->in('article_sort_id', $categoryId);
    	$result = $this->getRowByCondition($where,$column,null,null,array('id'=>'desc'));
    	$result = array_slice($result,0,20);
    	return $result;
    }
    
    
    
    
    
   
}