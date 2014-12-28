<?php
class Atwix_Ulogin_LoginController extends Mage_Core_Controller_Front_Action
{
    /**
     * Processes login action
     * @return bool
     * @throws Exception
     */
    public function autologinAction()
    {
        $session = $this->_getSession();
        if (!$this->_isAllowed()) {
            $message = $this->__('You have no pemission to use this option');
            $session->addError($message);
            $this->_redirect('customer/account/login');
        }
        else {
            $id = (int) trim($this->getRequest()->getParam('customerid'));
            try{
                if($id){
                    $customer = Mage::getModel('customer/customer')->load($id);
                    $session->setCustomerAsLoggedIn($customer);
                    $message = $this->__('You are now logged in as %s', $customer->getName());
                    $session->addNotice($message);
                    Mage::log($message);
                }else{
                    throw new Exception ($this->__('The login attempt was unsuccessful. Some parameter is missing'));
                }
            }catch (Exception $e){
                $session->addError($e->getMessage());
            }
            $this->_redirect('customer/account');
        }
    }
 
    /**
     * Gets customer session
     * @return Mage_Core_Model_Abstract
     */
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }
 
    /**
     * Checks if ip is allowed for autologin
     * @return mixed
     */
    protected function _isAllowed()
    {
        $allowedIps = Mage::helper('ulogin')->getAllowedIps();
        return Mage::helper('ulogin')->checkAllowedIp($allowedIps);
    }

    //This method tells Magento to add one more item to Actions column “Login”. That’s all. You can try to go to Admin->Customers->Manage Customers. There will be a new action ‘Login’ in Actions column. Choose this action brings a new popup window where you will be logged in as a customer. Do not forget to clean up Magento cache.
}