<?php
class Likipe_Utility_Block_Myblock extends Mage_Core_Block_Template
{
     public function methodblock()
     {
        //on initialize la variable
        $retour='';
        /* we are doing the query to select all elements of the pfay_test table (thanks to our model test/test and we sort them by id_pfay_test */
        $collection = Mage::getModel('utility/utility')->getCollection()
                                 ->setOrder('id_likipe_utility','asc');
         /* then, we check the result of the query and with the function getData() */
        foreach($collection as $data)
        {
             $retour .= $data->getData('nom').' '.$data->getData('prenom')
                     .' '.$data->getData('telephone').'<br />';
         }
         //i return a success message to the user thanks to the Session.
         Mage::getSingleton('adminhtml/session')->addSuccess('Cool Ca marche !!');
         return $retour;
      }
 }