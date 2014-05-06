<?php
namespace Cms\Component\Article;

use Application\Model\BaseModel;
use Zend\Db\Adapter\Adapter;

class ContentModel extends BaseModel
{
    protected $table = 'razor_product';
    
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->initialize();
    }
    
    public function getArticleContent(){
    	
    	$select = $this->getSql()->select();
    	
    	//echo $select->getSqlString(new \Zend\Db\Adapter\Platform\Mysql());
    	
    	$data = $this->selectWith($select)->toArray();
    	
    	$data = array_slice($data,0,1);
    	
    	
    	
    	return $data;
    	
    }
    
    
   
}