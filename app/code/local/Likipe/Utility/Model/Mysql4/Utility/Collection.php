<?php
class Likipe_Utility_Model_Mysql4_Utility_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
 {
     public function _construct()
     {
         parent::_construct();
         $this->_init('utility/utility');
     }
}