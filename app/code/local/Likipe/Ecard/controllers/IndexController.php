<?php
class Likipe_Ecard_IndexController extends Mage_Core_Controller_Front_Action
{
    /*
     * To test Ecards functions...
     */
    public function indexAction()
    {
        echo  Mage::getStoreConfig('ecard_section/ecard_group/ecard_field');
    }
}