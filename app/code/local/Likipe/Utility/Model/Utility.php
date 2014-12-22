<?php
class Likipe_Utility_Model_Utility extends Mage_Core_Model_Abstract
{
     public function _construct()
     {
         parent::_construct();
         $this->_init('utility/utility');
     }
}