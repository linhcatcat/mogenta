<?php

class Likipe_Demo_Model_Mysql4_Demo extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct(){
		$this->_init('demo/demo', 'demo_id');
	}
}