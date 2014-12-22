<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Resource Model
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Model_Mysql4_Lesson06 extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('lesson06/lesson06', 'lesson06_id');
    }
}