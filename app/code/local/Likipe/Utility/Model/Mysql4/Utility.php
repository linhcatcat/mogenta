<?php
class Likipe_Utility_Model_Mysql4_Utility extends Mage_Core_Model_Mysql4_Abstract
{
     public function _construct()
     {
         $this->_init('utility/utility', 'id_likipe_utility');
     }
}