<?php
class Atwix_Ulogin_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Customer_Grid
{
    protected function _prepareColumns()
    {
        parent::_prepareColumns();
 
        $column = $this->getColumn('action');
        $actions = $column->getActions();
        $actions[] = array(
            'caption' => 'Log in',
            'popup' => true,
            'url' => array(
            'base' => 'ulogin/login/autologin'),
            'field' => 'customerid'
        );
        $column->setActions( $actions );
 
        return $this;
    }
}