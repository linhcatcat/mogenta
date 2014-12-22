<?php

class Likipe_Demo_Block_Adminhtml_Demo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$this->setForm($form);
		
		if (Mage::getSingleton('adminhtml/session')->getDemoData()){
			$data = Mage::getSingleton('adminhtml/session')->getDemoData();
			Mage::getSingleton('adminhtml/session')->setDemoData(null);
		}elseif(Mage::registry('demo_data'))
			$data = Mage::registry('demo_data')->getData();
		
		$fieldset = $form->addFieldset('demo_form', array('legend'=>Mage::helper('demo')->__('Item information')));

		$fieldset->addField('title', 'text', array(
			'label'		=> Mage::helper('demo')->__('Title'),
			'class'		=> 'required-entry',
			'required'	=> true,
			'name'		=> 'title',
		));

		$fieldset->addField('filename', 'file', array(
			'label'		=> Mage::helper('demo')->__('File'),
			'required'	=> false,
			'name'		=> 'filename',
		));

		$fieldset->addField('status', 'select', array(
			'label'		=> Mage::helper('demo')->__('Status'),
			'name'		=> 'status',
			'values'	=> Mage::getSingleton('demo/status')->getOptionHash(),
		));

		$fieldset->addField('content', 'editor', array(
			'name'		=> 'content',
			'label'		=> Mage::helper('demo')->__('Content'),
			'title'		=> Mage::helper('demo')->__('Content'),
			'style'		=> 'width:700px; height:500px;',
			'wysiwyg'	=> false,
			'required'	=> true,
		));

		$form->setValues($data);
		return parent::_prepareForm();
	}
}