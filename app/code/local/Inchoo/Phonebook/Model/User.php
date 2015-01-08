<?php
class Inchoo_Phonebook_Model_User extends Mage_Core_Model_Abstract
{
	/**
	* Maps to the array key from Setup.php::getDefaultEntities()
	*/
	const ENTITY = 'inchoo_phonebook_user';
	protected $_eventPrefix = 'inchoo_phonebook';
	protected $_eventObject = 'user';
	function _construct()
	{
		$this->_init('inchoo_phonebook/user');
	}
}