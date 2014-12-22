<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Adminhtml Block
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Block_Adminhtml_Lesson06 extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_lesson06';
        $this->_blockGroup = 'lesson06';
        $this->_headerText = Mage::helper('lesson06')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('lesson06')->__('Add Item');
        parent::__construct();
    }
}