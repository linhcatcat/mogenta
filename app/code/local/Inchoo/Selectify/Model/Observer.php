<?php
class Inchoo_Selectify_Model_Observer
{
    const MODULE_NAME = 'Inchoo_Selectify';
 
    public function convertQtyInputToSelect($observer = NULL)
    {
        if (!$observer) { 
            return;
        }
 
        if ('product.info.addtocart' == $observer->getEvent()->getBlock()->getNameInLayout()) {
 
            if (!Mage::getStoreConfig('advanced/modules_disable_output/'.self::MODULE_NAME)) {
 
                $transport = $observer->getEvent()->getTransport();
 
                $block = new Inchoo_Selectify_Block_QtyInputToSelect();
                $block->setPassingTransport($transport['html']);
                $block->toHtml();
            }
        }
 
        return $this;
    }
}