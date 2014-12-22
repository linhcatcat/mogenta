<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Edit Form Content Tab Block
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare tab form's information
     *
     * @return Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit_Tab_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        
        if (Mage::getSingleton('adminhtml/session')->getLesson06Data()) {
            $data = Mage::getSingleton('adminhtml/session')->getLesson06Data();
            Mage::getSingleton('adminhtml/session')->setLesson06Data(null);
        } elseif (Mage::registry('lesson06_data')) {
            $data = Mage::registry('lesson06_data')->getData();
        }
        $fieldset = $form->addFieldset('lesson06_form', array(
            'legend'=>Mage::helper('lesson06')->__('Item information')
        ));

        $fieldset->addField('title', 'text', array(
            'label'        => Mage::helper('lesson06')->__('Title'),
            'class'        => 'required-entry',
            'required'    => true,
            'name'        => 'title',
        ));

        $fieldset->addField('filename', 'file', array(
            'label'        => Mage::helper('lesson06')->__('File'),
            'required'    => false,
            'name'        => 'filename',
        ));

        $fieldset->addField('status', 'select', array(
            'label'        => Mage::helper('lesson06')->__('Status'),
            'name'        => 'status',
            'values'    => Mage::getSingleton('lesson06/status')->getOptionHash(),
        ));

        $fieldset->addField('content', 'editor', array(
            'name'        => 'content',
            'label'        => Mage::helper('lesson06')->__('Content'),
            'title'        => Mage::helper('lesson06')->__('Content'),
            'style'        => 'width:700px; height:500px;',
            'wysiwyg'    => false,
            'required'    => true,
        ));

        $form->setValues($data);
        return parent::_prepareForm();
    }
}