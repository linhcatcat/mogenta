<?php
class Likipe_Utility_Block_Adminhtml_Utility_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		//vwe assign the same blockGroup as the Grid Container
		$this->_blockGroup = 'utility';
		//and the same controller
		$this->_controller = 'adminhtml_utility';
		//define the label for the save and delete button
		$this->_updateButton('save', 'label','save reference');
		$this->_updateButton('delete', 'label', 'delete reference');
	}
	/* Here, we're looking if we have transmitted a form object,
	to update the good text in the header of the page (edit or add) */
	public function getHeaderText()
	{
		if( Mage::registry('utility_data')&&Mage::registry('utility_data')->getId())
		{
			return 'Edit Reference '.$this->htmlEscape(Mage::registry('utility_data')->getTitle()).'<br />';
		} else {
			return 'Add a contact';
		}
	}
}