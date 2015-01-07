<?php
/**
 * Translate model
 *
 * @author      Inchoo <ivan.galambos@inchoo.net>
 */
class Inchoo_Translate_Model_Mage_Core_Model_Translate extends Mage_Core_Model_Translate
{
	/**
	 * Retrieve locale
	 *
	 * @return string
	 */
	public function getLocale()
	{
		$this->_locale = Mage::app()->getLocale()->getLocaleCode();
		return $this->_locale;
	}
}