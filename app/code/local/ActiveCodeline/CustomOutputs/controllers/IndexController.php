<?php

class ActiveCodeline_CustomOutputs_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {   
    	//Get current layout state 
    	$this->loadLayout();	
    	    	
    	$block = $this->getLayout()->createBlock(
		    'Mage_Core_Block_Template',
		    'my_block_name_here',
			array('template' => 'activecodeline/developer.phtml')
		);
    	
    	$this->getLayout()->getBlock('content')->append($block);

    	//Release layout stream
    	$this->renderLayout();
    }
}