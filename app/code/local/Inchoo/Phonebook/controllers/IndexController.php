<?php

class Inchoo_Phonebook_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$phonebookUser = Mage::getModel('inchoo_phonebook/user');
		$phonebookUser->setFristname('John');
		$phonebookUser->setLastname('Doe');
		$phonebookUser->setEmail('john.doe@magento.com');
		$phonebookUser->setAddress('Sample address line here');
		$phonebookUser->setIsActive(true);
		//$phonebookUser->save();
		Zend_Debug::dump($phonebookUser->debug(), '$phonebookUser');
		$users = Mage::getModel('inchoo_phonebook/user')->getCollection();
		foreach($users as $user) {
			Zend_Debug::dump($user->debug(), '$user');
		} 
	}
}