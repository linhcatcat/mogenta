<?php

/**
 * @category   Inchoo
 * @package    Inchoo_AddAllToCart
 * @author     Mladen Lotar - mladen.lotar@surgeworks.com
 *
 * @warning    Please don't install this extension to your site, it was created as April fools joke
 */

class Inchoo_AddAllToCart_IndexController extends Mage_Core_Controller_Front_Action
{
	public function addEverythingAction()
	{
		$_items = Mage::getSingleton('catalog/product')->getCollection()->addFieldToFilter('type_id', 'simple');
		$cart = Mage::getModel('checkout/cart');
		foreach ($_items as $_item) {
			$cart->addProductsByIds(array($_item->getData('entity_id')));
		}
		$cart->save();

		//Redirect back to cart or wherever you wish
		$this->_redirect('checkout/cart');
	}
}
