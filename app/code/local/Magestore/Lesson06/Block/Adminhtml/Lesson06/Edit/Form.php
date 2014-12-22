<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Edit Form Block
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare form's information for block
     *
     * @return Magestore_Lesson06_Block_Adminhtml_Lesson06_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array(
                'id'    => $this->getRequest()->getParam('id'),
            )),
            'method'    => 'post',
            'enctype'   => 'multipart/form-data'
        ));

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}