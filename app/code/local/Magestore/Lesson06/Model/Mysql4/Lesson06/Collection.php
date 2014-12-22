<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Resource Collection Model
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Model_Mysql4_Lesson06_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('lesson06/lesson06');
    }
}