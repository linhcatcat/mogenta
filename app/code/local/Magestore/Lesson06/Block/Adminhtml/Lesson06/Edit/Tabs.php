<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Edit Tabs Block
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('lesson06_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('lesson06')->__('Item Information'));
    }
    
    /**
     * prepare before render block to html
     *
     * @return Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit_Tabs
     */
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('lesson06')->__('Item Information'),
            'title'     => Mage::helper('lesson06')->__('Item Information'),
            'content'   => $this->getLayout()
                                ->createBlock('lesson06/adminhtml_lesson06_edit_tab_form')
                                ->toHtml(),
        ));
        return parent::_beforeToHtml();
    }
}