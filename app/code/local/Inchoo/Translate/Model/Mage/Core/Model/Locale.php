<?php
/**
 * Locale model
 * 
 * @author     Inchoo <ivan.galambos@inchoo.net>
 */
class Inchoo_Translate_Model_Mage_Core_Model_Locale extends Mage_Core_Model_Locale
{
	/**
	 * Create Zend_Date object with date converted to store timezone and store Locale
	 *
	 * @param   mixed $store Information about store
	 * @param   string|integer|Zend_Date|array|null $date date in UTC
	 * @param   boolean $includeTime flag for including time to date
	 * @return  Zend_Date
	 */
	public function getStoreDate($store=null, $date=null, $includeTime=false)
	{
		$timezone = Mage::app()->getStore($store)->getConfig(self::XML_PATH_DEFAULT_TIMEZONE);
		$locale = Mage::app()->getStore($store)->getConfig(self::XML_PATH_DEFAULT_LOCALE);
		$date = new Zend_Date($date, null, $locale);
		$date->setTimezone($timezone);
		if (!$includeTime) {
			$date->setHour(0)
				->setMinute(0)
				->setSecond(0);
		}
		return $date;
	}

	/**
	 * Returns a localized information string, supported are several types of informations.
	 * For detailed information about the types look into the documentation
	 *
	 * @param  string             $value  Name to get detailed information about
	 * @param  string             $path   (Optional) Type of information to return
	 * @return string|false The wished information in the given language
	 */
	public function getTranslationByLocaleCode($value = null, $path = null, $localeCode = null)
	{
		return $this->getLocale()->getTranslation($value, $path, $localeCode/*$this->getLocale()*/);
	}

	/**
	 * Retrieve ISO date format
	 *
	 * @param   string $type
	 * @return  string
	 */
	public function getDateFormatByLocaleCode($type=null, $localeCode)
	{
		return $this->getTranslationByLocaleCode($type, 'date', $localeCode);
	}

	/**
	 * Retrieve ISO time format
	 *
	 * @param   string $type
	 * @return  string
	 */
	public function getTimeFormatByLocaleCode($type=null, $localeCode)
	{
		return $this->getTranslationByLocaleCode($type, 'time', $localeCode);
	}

	/**
	 * Retrieve ISO datetime format
	 *
	 * @param   string $type
	 * @return  string
	 */
	public function getDateTimeFormatByLocaleCode($type, $localeCode)
	{
		return $this->getDateFormatByLocaleCode($type, $localeCode) . ' ' . $this->getTimeFormatByLocaleCode($type, $localeCode);
	}
}