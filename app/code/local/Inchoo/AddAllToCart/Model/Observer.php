<?php

/**
 * @category   Inchoo
 * @package    Inchoo_AddAllToCart
 * @author     Mladen Lotar - mladen.lotar@surgeworks.com
 *
 * @warning    Please don't install this extension to your site, it was created as April fools joke
 */

class Inchoo_AddAllToCart_Model_Observer
{
	const MODULE_NAME = 'Inchoo_AddAllToCart';

	public function injectLinkCart($observer = NULL)
	{
		if (!$observer) {
			return;
		}
		//var_dump($observer->getEvent()->getBlock()->getNameInLayout());
		if ('top.links' == $observer->getEvent()->getBlock()->getNameInLayout()) {
			if (!Mage::getStoreConfig('advanced/modules_disable_output/'.self::MODULE_NAME)) {
				$transport = $observer->getEvent()->getTransport();
				$block = new Inchoo_AddAllToCart_Block_Injection();
				$block->setPassingTransport($transport['html'], 'AddAllToCart.phtml');
				$block->toHtml();
			}
		}

		return $this;
	}
}
