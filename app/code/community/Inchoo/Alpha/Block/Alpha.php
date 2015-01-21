<?php

class Inchoo_Alpha_Block_Alpha extends Mage_Core_Block_Template
{
    /**
     * Constructor. Set template.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('inchoo/alpha/alpha.phtml');
    }
}