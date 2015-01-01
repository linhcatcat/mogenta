<?php
class Mage_Adminhtml_Block_Catalog_Product_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /*public function render(Varien_Object $row)
    {
        $_product = Mage::getModel('catalog/product')->load($row->getEntityId());
        if($_product->getImage() != 'no_selection'){
              $image = "<img src='".Mage::helper('catalog/image')->init($_product, 'image')->resize(100)."' title='".$_product->getName()."' />";
        }
        return $image;
    }*/

    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    } 
    protected function _getValue(Varien_Object $row)
    {       
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        $url = Mage::getBaseUrl('media') . 'catalog/product' . $val; 
        $out = "<img src=". $url ." width='60px'/>"; 
        return $out;
    }
}