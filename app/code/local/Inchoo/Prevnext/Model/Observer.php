<?php
class Inchoo_Prevnext_Model_Observer
{
	public function setInchooFilteredCategoryProductCollection()
	{
		/**
		 * There might be some illogical buggy behavior when coming directly 
		 * from "Related products" / "Recently viewed" products block. 
		 * Nothing that should break the page however.
		 */
		if (Mage::app()->getRequest()->getControllerName() == 'category' && Mage::app()->getRequest()->getActionName() == 'view') {

			$products = Mage::app()->getLayout()
					->getBlockSingleton('Mage_Catalog_Block_Product_List')
					->getLoadedProductCollection()
					->getColumnValues('entity_id');

			Mage::getSingleton('core/session')
					->setInchooFilteredCategoryProductCollection($products);

			unset($products);
		}
		return $this;
	}
}