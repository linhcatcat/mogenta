<?php
class Inchoo_GPlusOne_Block_PlusButton extends Mage_Core_Block_Template
{
	/**
	 * Constructor. Set template.
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('inchoo/gplusone_button.phtml');
	}
 
	public function getSize() 
	{
		//Here we can implement the code to read the config values for sizes
		return '';
	}
}