<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Edit Block
 * 
 * @category     Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        
        $this->_objectId = 'id';
        $this->_blockGroup = 'lesson06';
        $this->_controller = 'adminhtml_lesson06';
        
        $this->_updateButton('save', 'label', Mage::helper('lesson06')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('lesson06')->__('Delete Item'));
        
        $this->_addButton('saveandcontinue', array(
            'label'        => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'    => 'saveAndContinueEdit()',
            'class'        => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('lesson06_content') == null)
                    tinyMCE.execCommand('mceAddControl', false, 'lesson06_content');
                else
                    tinyMCE.execCommand('mceRemoveControl', false, 'lesson06_content');
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
    
    /**
     * get text to show in header when edit an item
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('lesson06_data')
            && Mage::registry('lesson06_data')->getId()
        ) {
            return Mage::helper('lesson06')->__("Edit Item '%s'",
                                                $this->htmlEscape(Mage::registry('lesson06_data')->getTitle())
            );
        }
        return Mage::helper('lesson06')->__('Add Item');
    }
}