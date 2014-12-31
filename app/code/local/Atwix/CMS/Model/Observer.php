<?php
 
class Atwix_CMS_Model_Observer extends Varien_Event_Observer
{
    public function cmsField($observer)
    {
        //get CMS model with data
        $model = Mage::registry('cms_page');
        //get form instance
        $form = $observer->getForm();
        //create new custom fieldset 'atwix_content_fieldset'
        $fieldset = $form->addFieldset('atwix_content_fieldset', array('legend'=>Mage::helper('cms')->__('Custom'),'class'=>'fieldset-wide'));
        //add new field
        $fieldset->addField('content_custom', 'text', array(
            'name'      => 'content_custom',
            'label'     => Mage::helper('cms')->__('Content Custom'),
            'title'     => Mage::helper('cms')->__('Content Custom'),
            'disabled'  => false,
            //set field value
            'value'     => $model->getContentCustom()
        ));
    }

    public function savePage($observer)
    {
        $event = $observer->getEvent();
        $cmsPage = Mage::getSingleton('cms/page')->getPage();
        //$cmsPage->save();
        var_dump($cmsPage);exit();
    }
}