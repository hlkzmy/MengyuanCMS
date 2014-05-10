<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Etah\Mvc\Form\Element;

use Zend\Form\Element;

/**
 * @copyright  Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class DwzLookup extends Element
{
    /**
     * Seed attributes
     *
     * @var array
     */
    protected $attributes = array(
        			'type' => 'dwz_lookup',
    		  );
    
    
    public function setValue($value){

    	$value = explode('.',$value);
    	
    	$this->setAttribute('hidden_value' ,$value[0]) ;
    	$this->setAttribute('display_value',$value[1]) ;
    	
    	return $this;
    }
    
    
    
}
