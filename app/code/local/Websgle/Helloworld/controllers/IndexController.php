<?php


class Websgle_Helloworld_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        // "Fetch" display
        $this->loadLayout();
     
        // "Inject" into display
        // THe below example will not actualy show anything since the core/template is empty
        //$this->_addContent($this->getLayout()->createBlock('core/template'));
     
        // echo "Hello developer...";
     
        // "Output" display
        $this->renderLayout();
    }

    public function addAction()
    {
        echo 'add function';
    }

    public function editAction()
    {
        echo 'edit function';
    }

    public function deleteAction()
    {
        echo 'delete function';
    }

}