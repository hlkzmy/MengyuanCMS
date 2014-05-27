<?php

namespace Cms\Component\Article\ListControl\Model;

use Application\Model\BaseModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Where;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

use Zend\Paginator\Paginator;//换页对象
use Zend\Paginator\Adapter\DbSelect;//因为是从数据库读取的适配器对象


class Article extends BaseModel
{
    protected $table = 'resource_article';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    /**
     * 文章标题的换页对象和数据查询的方法
     * @param  $categoryId
     */
    public function getPaginator($categoryId,array $column){
    	
    	//1.设置数据库对象
    	$where = new Where();
    	$where->in('article_sort_id', $categoryId);
    	
    	
    	$select = new Select();
		$select->from($this->table);
		$select->columns($column);
    	$select->where($where);
    	
    	//2.设置换页适配器对象
    	$resultSet = new ResultSet(ResultSet::TYPE_ARRAY);
    
    	$paginationAdapter = new DbSelect($select,$this->adapter,$resultSet);
    	
    	//3.设置换页对象
    	$paginator = new Paginator($paginationAdapter);
    	
    	return $paginator;
    	
    }//function getPaginator();
    
    
    
    
    
   
}