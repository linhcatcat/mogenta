<?php
/**
 * Translate helper
 *
 * @author      Inchoo <ivan.galambos@inchoo.net>
 */
class Inchoo_Translate_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Format date using specifed locale
	 *
	 * @param   date|Zend_Date|null $date in GMT timezone
	 * @param   string $format
	 * @param   bool $showTime
	 * @return  string
	 */
	public function formatDateByLocaleCode($date=null, $format='short', $showTime=false, $localeCode=null)
	{
		if ($localeCode === null || !is_string($localeCode)) {
			$localeCode = Mage::getStoreConfig('general/locale/code');
		}
		if (Mage_Core_Model_Locale::FORMAT_TYPE_FULL    	!==$format &&
				Mage_Core_Model_Locale::FORMAT_TYPE_LONG    !==$format &&
				Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM  !==$format &&
				Mage_Core_Model_Locale::FORMAT_TYPE_SHORT   !==$format) {
			return $date;
		}
		if (!($date instanceof Zend_Date) && $date && !strtotime($date)) {
			return '';
		}
		if (is_null($date)) {
			$date = Mage::app()->getLocale()->date(Mage::getSingleton('core/date')->gmtTimestamp(), null, null);
		}
		elseif (!$date instanceof Zend_Date) {
			$date = Mage::app()->getLocale()->date(strtotime($date), null, null, $showTime);
		}

		if ($showTime) {
			$format = Mage::app()->getLocale()->getDateTimeFormatByLocaleCode($format, $localeCode);
		}
		else {
			$format = Mage::app()->getLocale()->getDateFormatByLocaleCode($format, $localeCode);
		}
		return $date->toString($format);
	}
}