<?php
class Company_Web_Block_Web extends Mage_Core_Block_Template
{
	public function _prepareLayout() {
		return parent::_prepareLayout();
    }
    
    public function getWeb() {
        if (!$this->hasData('web')) {
            $this->setData('web', Mage::registry('web'));
        }
        return $this->getData('web');
    }

    public function methodblock() {

        //on initialize la variable
        $retour='';
        /* we are doing the query to select all elements of the pfay_test table (thanks to our model web/web and we sort them by id_pfay_test */
        $collection = Mage::getModel('web/web')->getCollection()
                                 ->setOrder('web_id','asc');
         /* then, we check the result of the query and with the function getData() */
        foreach($collection as $data) {
             $retour .= $data->getData('title').' | '.$data->getData('content').' | '.$data->getData('status').'<br />';
         }
         //i return a success message to the user thanks to the Session.
         Mage::getSingleton('adminhtml/session')->addSuccess('Cool Ca marche !!');
         return $retour;
    }
}