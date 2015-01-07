<?php
class Inchoo_Prevnext_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * @return Mage_Catalog_Model_Product or FALSE
	 */
	public function getPreviousProduct()
	{
		$prodId = Mage::registry('current_product')->getId();

		$positions = Mage::getSingleton('core/session')->getInchooFilteredCategoryProductCollection();

		if (!$positions) {
			$positions = array_reverse(array_keys(Mage::registry('current_category')->getProductsPosition()));
		}

		$cpk = @array_search($prodId, $positions);

		$slice = array_reverse(array_slice($positions, 0, $cpk));

		foreach ($slice as $productId) {
			$product = Mage::getModel('catalog/product')->load($productId);
			if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
					return $product;
			}
		}

		return false;
	}

	/**
	 * @return Mage_Catalog_Model_Product or FALSE
	 */
	public function getNextProduct()
	{
		$prodId = Mage::registry('current_product')->getId();

		$positions = Mage::getSingleton('core/session')->getInchooFilteredCategoryProductCollection();

		if (!$positions) {
			$positions = array_reverse(array_keys(Mage::registry('current_category')->getProductsPosition()));
		}

		$cpk = @array_search($prodId, $positions);

		$slice = array_slice($positions, $cpk + 1, count($positions));

		foreach ($slice as $productId) {
			$product = Mage::getModel('catalog/product')->load($productId);
			if ($product && $product->getId() && $product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
				return $product;
			}
		}

		return false;
	}
}