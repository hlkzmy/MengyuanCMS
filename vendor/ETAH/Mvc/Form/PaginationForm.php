<?php
namespace Etah\Mvc\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;

class PaginationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct ('paginationForm');

        $pageRowCountSelect = new Select();
        $pageRowCountSelect->setName('pageRowCount');
        
        $pageRowCountSelect->setAttribute('onchange',"navTabPageBreak({numPerPage:this.value})");
         
        $pageRowCountSelect->setValueOptions(
        										array(
        											
        											'30'=>30,	
        											'60'=>60,	
        											'80'=>80,	
        											'100'=>100,
        										)
        		
        									);
        
        $this->add($pageRowCountSelect);

    }
    
}
