<?php

/**
 * 
 * Access like 
 * https://magenti.co/alpha/
 * or
 * https://magenti.co/alpha/index/index/
 * 
 */
class Inchoo_Alpha_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		
		
		$this->loadLayout();
		$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
		$this->getLayout()->getBlock('content')->insert($this->getLayout()->createBlock('alpha/alpha'));
		$this->renderLayout();	
	}
	
	public function createAction()
	{
		$params = $this->getRequest()->getParam('module');
		
		$module = Mage::getModel('alpha/alpha');
		$module->setModuleParamas($params);
		echo $module->create(); exit;

//		$this->loadLayout();
//		$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
//		$this->getLayout()->getBlock('content')->insert($this->getLayout()->createBlock('alpha/alpha'));
//		$this->renderLayout();			
	}	
}