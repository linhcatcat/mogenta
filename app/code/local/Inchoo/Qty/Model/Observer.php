<?php

/**
 * @category   Inchoo
 * @package    Inchoo_Qty
 * @author     Mladen Lotar - mladen.lotar@surgeworks.com
 */

class Inchoo_Qty_Model_Observer
{
	const MODULE_NAME = 'Inchoo_Qty';

	public function injectJavascriptForQty($observer = NULL)
	{
		if (!$observer) {
			return;
		}
//Zend_Debug::dump($observer->getEvent()->getBlock()->getNameInLayout());
		if ('product.info.addtocart' == $observer->getEvent()->getBlock()->getNameInLayout()) {

			if (!Mage::getStoreConfig('advanced/modules_disable_output/'.self::MODULE_NAME)) {
				$transport = $observer->getEvent()->getTransport();
				$block = new Inchoo_Qty_Block_Injection();
				$block->setPassingTransport($transport['html']);
				$block->toHtml();
			}
		}

		return $this;
	}
}