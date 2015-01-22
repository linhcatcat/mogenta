<?php

class Ajzele_SimpleModel_Model_Mysql4_Hello extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
    	
        $this->_init('hello/hello', 'hello_id');
        
        
    }
}