<?php

require_once 'Mage/Wishlist/controllers/IndexController.php';

class Likipe_Customerwishlist_IndexController extends Mage_Wishlist_IndexController {

    public function preDispatch() {
        parent::preDispatch();
        $preDispatchSession = 1;
        if (!$this->_skipAuthentication && !$preDispatchSession) {
            $this->setFlag('', 'no-dispatch', true);
            if (!Mage::getSingleton('customer/session')->getBeforeWishlistUrl()) {
                Mage::getSingleton('customer/session')->setBeforeWishlistUrl($this->_getRefererUrl());
            }
            Mage::getSingleton('customer/session')->setBeforeWishlistRequest($this->getRequest()->getParams());
        }
        if (!Mage::getStoreConfigFlag('wishlist/general/active')) {
            $this->norouteAction();
            return;
        }
    }

    public function updateAction() {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }
        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            return $this->norouteAction();
        }

        $post = $this->getRequest()->getPost();
        if ($post && isset($post['description']) && is_array($post['description'])) {
            $updatedItems = 0;

            foreach ($post['description'] as $itemId => $description) {
                $item = Mage::getModel('wishlist/item')->load($itemId);
                if ($item->getWishlistId() != $wishlist->getId()) {
                    continue;
                }

                // Extract new values
                $description = (string) $description;
                if (!strlen($description)) {
                    $description = $item->getDescription();
                }

                $qty = null;
                if (isset($post['qty'][$itemId])) {
                    $qty = $this->_processLocalizedQty($post['qty'][$itemId]);
                }
                if (is_null($qty)) {
                    $qty = $item->getQty();
                    if (!$qty) {
                        $qty = 1;
                    }
                } elseif (0 == $qty) {
                    try {
                        $item->delete();
                    } catch (Exception $e) {
                        Mage::logException($e);
                        Mage::getSingleton('customer/session')->addError(
                                $this->__('Can\'t delete item from wishlist')
                        );
                    }
                }

                // Check that we need to save
                if (($item->getDescription() == $description) && ($item->getQty() == $qty)) {
                    continue;
                }
                try {
                    $item->setDescription($description)
                            ->setQty($qty)
                            ->save();
                    $updatedItems++;
                } catch (Exception $e) {
                    Mage::getSingleton('customer/session')->addError(
                            $this->__('Can\'t save description %s', Mage::helper('core')->htmlEscape($description))
                    );
                }
            }

            // save wishlist model for setting date of last update
            if ($updatedItems) {
                try {
                    $wishlist->save();
                    Mage::helper('wishlist')->calculate();
                } catch (Exception $e) {
                    Mage::getSingleton('customer/session')->addError($this->__('Can\'t update wishlist'));
                }
            }

            if (isset($post['save_and_share'])) {
                $this->_redirect('*/*/share', array('wishlist_id' => $wishlist->getId()));
                return;
            }
        }
        $this->_redirect('*', array('wishlist_id' => $wishlist->getId()));
    }

    public function removeWishListAction() {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if ($customerId == '') {
            $visitorData = Mage::getSingleton('core/session')->getVisitorData();
            $customerId = $visitorData['visitor_id'];
        }
        $itemCollection = Mage::getModel('wishlist/item')->getCollection()
                ->addCustomerIdFilter($customerId);

        foreach ($itemCollection as $item) {
            $item->delete();
        }
        $this->_redirectReferer(Mage::getUrl('*/*'));
    }

    /**
     * Update wishlist item comments
     */
    public function updateajaxAction() {
        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            return $this->norouteAction();
        }
        $post = $this->getRequest()->getPost();

        if ($post) {
            $updatedItems = 0;
            $item = Mage::getModel('wishlist/item')->load($post['item_id']);
            $qty = null;
            if (isset($post['qty'])) {

                $qty = $this->_processLocalizedQty($post['qty']);
            }
            if (is_null($qty)) {
                $qty = $item->getQty();
                if (!$qty) {
                    $qty = 1;
                }
            } elseif (0 == $qty) {
                try {
                    $item->delete();
                } catch (Exception $e) {
                    Mage::logException($e);
                    Mage::getSingleton('customer/session')->addError(
                            $this->__('Can\'t delete item from wishlist')
                    );
                }
            }
            // Check that we need to save

            try {
                $item->setQty($qty)
                        ->save();
                $updatedItems++;
            } catch (Exception $e) {
                Mage::getSingleton('customer/session')->addError(
                        $this->__('Can\'t save Product to wishlist')
                );
            }

            // save wishlist model for setting date of last update
            if ($updatedItems) {
                try {
                    $wishlist->save();
                    Mage::helper('wishlist')->calculate();
                } catch (Exception $e) {
                    Mage::getSingleton('customer/session')->addError($this->__('Can\'t update wishlist'));
                }
            }
            if (isset($post['save_and_share'])) {
                $this->_redirect('*/*/share', array('wishlist_id' => $wishlist->getId()));
                return;
            }
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function addAction() {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if ($customerId == '') {
            $visitorData = Mage::getSingleton('core/session')->getVisitorData();
            $customerId = $visitorData['visitor_id'];
        }
        $resultCustomer = Mage::getModel('customer/customer')->getCollection()->addFieldToFilter('entity_id', array('eq' => $customerId));
        foreach ($resultCustomer as $data) {
            $entity_id = $data['entity_id'];
        }
        $total_rows = count($resultCustomer);
        if (!$total_rows) {
            $resultCustomer = Mage::getModel('customer/customer');
            $resultCustomer->setData('entity_id', $customerId);
            $resultCustomer->setData('entity_type_id', '1');
            $resultCustomer->setData('email', 'guest@guest.com');
            $resultCustomer->save();
        }
        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            return $this->norouteAction();
        }
        $session = Mage::getSingleton('customer/session');
        $productId = (int) $this->getRequest()->getParam('product');
        if (!$productId) {
            $this->_redirect('*/');
            return;
        }
        $product = Mage::getModel('catalog/product')->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            $session->addError($this->__('Cannot specify product.'));
            $this->_redirect('*/');
            return;
        }
        try {
            $requestParams = $this->getRequest()->getParams();
            if ($session->getBeforeWishlistRequest()) {
                $requestParams = $session->getBeforeWishlistRequest();
                $session->unsBeforeWishlistRequest();
            }
            $buyRequest = new Varien_Object($requestParams);
            $result = $wishlist->addNewItem($product, $buyRequest);
            if (is_string($result)) {
                Mage::throwException($result);
            }
            $wishlist->save();
            Mage::dispatchEvent(
                    'wishlist_add_product', array(
                'wishlist' => $wishlist,
                'product' => $product,
                'item' => $result
                    )
            );
            $referer = $session->getBeforeWishlistUrl();
            if ($referer) {
                $session->setBeforeWishlistUrl(null);
            } else {
                $referer = $this->_getRefererUrl();
            }
            /**
             *  Set referer to avoid referring to the compare popup window
             */
            $session->setAddActionReferer($referer);
            Mage::helper('wishlist')->calculate();
        } catch (Mage_Core_Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist: %s', $e->getMessage()));
        } catch (Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist.'));
        }
        Mage::getSingleton('core/session')->setWishlistId($wishlist->getId());
        $this->_redirectReferer();
    }
    
    public function addajaxAction() {
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if ($customerId == '') {
            $visitorData = Mage::getSingleton('core/session')->getVisitorData();
            $customerId = $visitorData['visitor_id'];
        }
        $resultCustomer = Mage::getModel('customer/customer')->getCollection()->addFieldToFilter('entity_id', array('eq' => $customerId));
        foreach ($resultCustomer as $data) {
            $entity_id = $data['entity_id'];
        }
        $total_rows = count($resultCustomer);
        if (!$total_rows) {
            $resultCustomer = Mage::getModel('customer/customer');
            $resultCustomer->setData('entity_id', $customerId);
            $resultCustomer->setData('entity_type_id', '1');
            $resultCustomer->setData('email', 'guest@guest.com');
            $resultCustomer->save();
        }
        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            return $this->norouteAction();
        }
        $session = Mage::getSingleton('customer/session');
        $productId = (int) $this->getRequest()->getParam('product');
        if (!$productId) {
            $this->_redirect('*/');
            return;
        }
        $product = Mage::getModel('catalog/product')->load($productId);
        if (!$product->getId() || !$product->isVisibleInCatalog()) {
            $session->addError($this->__('Cannot specify product.'));
            $this->_redirect('*/');
            return;
        }
        try {
            $requestParams = $this->getRequest()->getParams();
            if ($session->getBeforeWishlistRequest()) {
                $requestParams = $session->getBeforeWishlistRequest();
                $session->unsBeforeWishlistRequest();
            }
            $buyRequest = new Varien_Object($requestParams);
            $result = $wishlist->addNewItem($product, $buyRequest);
            if (is_string($result)) {
                Mage::throwException($result);
            }
            $wishlist->save();
            Mage::dispatchEvent(
                'wishlist_add_product', array(
                'wishlist' => $wishlist,
                'product' => $product,
                'item' => $result
                    )
            );
            $referer = $session->getBeforeWishlistUrl();
            if ($referer) {
                $session->setBeforeWishlistUrl(null);
            } else {
                $referer = $this->_getRefererUrl();
            }
            /**
             *  Set referer to avoid referring to the compare popup window
             */
            $session->setAddActionReferer($referer);
            Mage::helper('wishlist')->calculate();
        } catch (Mage_Core_Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist: %s', $e->getMessage()));
        } catch (Exception $e) {
            $session->addError($this->__('An error occurred while adding item to wishlist.'));
        }
        Mage::getSingleton('core/session')->setWishlistId($wishlist->getId());
        $this->loadLayout();
        $this->renderLayout();
    }

    public function sendAction() {
        if (!$this->_validateFormKey()) {
            return $this->_redirect('*/*/');
        }

        $wishlist = $this->_getWishlist();
        if (!$wishlist) {
            return $this->norouteAction();
        }

        $emails = explode(',', $this->getRequest()->getPost('emails'));
        $name_customer = $this->getRequest()->getPost('name_customer');
        $message = nl2br(htmlspecialchars((string) $this->getRequest()->getPost('message')));
        $error = false;
        if (empty($emails)) {
            $error = $this->__('Email address can\'t be empty.');
        } else {
            foreach ($emails as $index => $email) {
                $email = trim($email);
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    $error = $this->__('Please input a valid email address.');
                    break;
                }
                $emails[$index] = $email;
            }
        }
        if ($error) {
            Mage::getSingleton('wishlist/session')->addError($error);
            Mage::getSingleton('wishlist/session')->setSharingForm($this->getRequest()->getPost());
            $this->_redirect('*/*/share');
            return;
        }

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        try {
            $customer = Mage::getSingleton('customer/session')->getCustomer();

            /* if share rss added rss feed to email template */
            if ($this->getRequest()->getParam('rss_url')) {
                $rss_url = $this->getLayout()
                        ->createBlock('wishlist/share_email_rss')
                        ->setWishlistId($wishlist->getId())
                        ->toHtml();
                $message .=$rss_url;
            }
            $wishlistBlock = $this->getLayout()->createBlock('wishlist/share_email_items')->toHtml();

            $emails = array_unique($emails);
            /* @var $emailModel Mage_Core_Model_Email_Template */
            $emailModel = Mage::getModel('core/email_template');
            $sharingCode = $wishlist->getSharingCode();
            foreach ($emails as $email) {
                $emailModel->sendTransactional(
                        Mage::getStoreConfig('wishlist/email/email_template'), Mage::getStoreConfig('wishlist/email/email_identity'), $email, null, array(
                    'customer' => $customer,
                    'salable' => $wishlist->isSalable() ? 'yes' : '',
                    'items' => $wishlistBlock,
                    'addAllLink' => Mage::getUrl('*/shared/allcart', array('code' => $sharingCode)),
                    'viewOnSiteLink' => Mage::getUrl('*/shared/index', array('code' => $sharingCode)),
                    'message' => $message,
                    'name_customer' => $name_customer
                        )
                );
            }
            $wishlist->setShared(1);
            $wishlist->save();

            $translate->setTranslateInline(true);

            Mage::dispatchEvent('wishlist_share', array('wishlist' => $wishlist));
            Mage::getSingleton('customer/session')->addSuccess(
                    $this->__('Your Wishlist has been shared.')
            );
            $this->_redirect('*/*', array('wishlist_id' => $wishlist->getId()));
        } catch (Exception $e) {
            $translate->setTranslateInline(true);

            Mage::getSingleton('wishlist/session')->addError($e->getMessage());
            Mage::getSingleton('wishlist/session')->setSharingForm($this->getRequest()->getPost());
            $this->_redirect('*/*/share');
        }
    }

}

?>