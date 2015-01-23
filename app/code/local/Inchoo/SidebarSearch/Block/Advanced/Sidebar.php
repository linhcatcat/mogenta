<?php
class Inchoo_SidebarSearch_Block_Advanced_Sidebar extends Mage_CatalogSearch_Block_Advanced_Form
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('sidebarsearch/advanced/sidebar.phtml');
	}

	public function _prepareLayout()
	{
		// don't change crumbs!
	}
	
	public function getAttributeSelectElement($attribute)
	{
		$extra = '';
		$options = $attribute->getSource()->getAllOptions(false);
		$name = $attribute->getAttributeCode();

		// 2 - avoid yes/no selects to be multiselects
//		if (is_array($options) && count($options)>2) {
//			$extra = 'multiple="multiple" size="4"';
//			$name.= '[]';
//		}
//		else {
			array_unshift($options, array('value'=>'', 'label'=>Mage::helper('catalogsearch')->__('Show All')));
//		}

		return $this->_getSelectBlock()
			->setName($name)
			->setId($attribute->getAttributeCode())
			->setTitle($this->getAttributeLabel($attribute))
			->setExtraParams($extra)
			->setValue($this->getAttributeValue($attribute))
			->setOptions($options)
			->setClass('multiselect')
			->getHtml();
	}
	
}