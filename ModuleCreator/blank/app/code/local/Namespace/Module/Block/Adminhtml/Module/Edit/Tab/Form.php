<?php

class <Namespace>_<Module>_Block_Adminhtml_<Module>_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$this->setForm($form);
		
		if (Mage::getSingleton('adminhtml/session')->get<Module>Data()){
			$data = Mage::getSingleton('adminhtml/session')->get<Module>Data();
			Mage::getSingleton('adminhtml/session')->set<Module>Data(null);
		}elseif(Mage::registry('<module>_data'))
			$data = Mage::registry('<module>_data')->getData();
		
		$fieldset = $form->addFieldset('<module>_form', array('legend'=>Mage::helper('<module>')->__('Item information')));

		$fieldset->addField('title', 'text', array(
			'label'		=> Mage::helper('<module>')->__('Title'),
			'class'		=> 'required-entry',
			'required'	=> true,
			'name'		=> 'title',
		));

		$fieldset->addField('filename', 'file', array(
			'label'		=> Mage::helper('<module>')->__('File'),
			'required'	=> false,
			'name'		=> 'filename',
		));

		$fieldset->addField('status', 'select', array(
			'label'		=> Mage::helper('<module>')->__('Status'),
			'name'		=> 'status',
			'values'	=> Mage::getSingleton('<module>/status')->getOptionHash(),
		));

		$fieldset->addField('content', 'editor', array(
			'name'		=> 'content',
			'label'		=> Mage::helper('<module>')->__('Content'),
			'title'		=> Mage::helper('<module>')->__('Content'),
			'style'		=> 'width:700px; height:500px;',
			'wysiwyg'	=> false,
			'required'	=> true,
		));

		$form->setValues($data);
		return parent::_prepareForm();
	}
}