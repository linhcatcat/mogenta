<?php
/**
 * http://films.local/index.php/ExpiringFilmsNotifier/index/notify
 */
class Inchoo_Translate_IndexController extends Mage_Core_Controller_Front_Action
{
	public function translateAction()
	{
		echo "<pre>";

		$defaultStore = Mage::app()->getStore()->getCode();
		$defaultLocale = Mage::app()->getLocale()->getLocaleCode();
		$stores = array(1,2,3);

		foreach ($stores as $storeId) {
			Mage::app()->setCurrentStore($storeId);
			$currentStore 	= Mage::app()->getStore()->getCode();
			$currentLocale 	= Mage::getModel('core/locale')->getLocaleCode();
			Mage::app()->getLocale()->setLocale($currentLocale);
			// reinitialize translation cache
			Mage::app()->getTranslator()->init('frontend', true);
			echo $currentLocale .' '. Mage::helper('core')->__("Welcome, %s!", Mage::helper('inchoo_translate')
				->formatDateByLocaleCode('2012-05-05 00:00:00', 'medium', false, $currentLocale))  . PHP_EOL;
		}
		//restore app to default values
		Mage::app()->setCurrentStore($defaultStore);
		Mage::app()->getLocale()->setLocale($defaultLocale);
		Mage::app()->getTranslator()->init('frontend', true);

		echo 'Did system restore default initialization?' . PHP_EOL;
		echo Mage::helper('core')->__("Welcome, %s!", Mage::helper('inchoo_translate')
				->formatDateByLocaleCode('2012-05-05 00:00:00', 'medium', false, $currentLocale))  . PHP_EOL;
		exit;
	}
}