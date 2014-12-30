<?php
class Atwix_Tweaks_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Returns generated CSV file
     */
    public function indexAction()
    {
    	$this->loadLayout();
		$this->renderLayout();
        /*$filename = 'mln.csv';
        $content = Mage::helper('atwix_tweaks/mln')->generateMlnList();
 
        $this->_prepareDownloadResponse($filename, $content);*/
    }
}