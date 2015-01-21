<?php

class Inchoo_Alpha_Model_Mysql4_Alpha extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('alpha/alpha', 'alpha_id');
    }	
}