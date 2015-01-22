<?php
class Ajzele_SimpleModel_Model_Mysql4_Hello_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{ 
    public function __construct()
    {
		$this->_init('hello/hello');
    }
}