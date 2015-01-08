<?php
class Inchoo_Phonebook_Model_Resource_User extends Mage_Eav_Model_Entity_Abstract
{
	public function __construct()
	{
		$resource = Mage::getSingleton('core/resource');
		$this->setType(Inchoo_Phonebook_Model_User::ENTITY);
		$this->setConnection(
			$resource->getConnection('inchoo_phonebook_read'),
			$resource->getConnection('inchoo_phonebook_write')
		);
	}
}