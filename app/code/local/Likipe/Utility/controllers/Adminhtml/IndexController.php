<?php

class Likipe_Utility_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
	protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('utility/set_time')->_addBreadcrumb('utility Manager','utility Manager');
       	return $this;
    }
	public function indexAction()
	{
		$this->_initAction();
		$this->renderLayout();
	}
	public function editAction()
    {
       	$utilityId = $this->getRequest()->getParam('id');
       	$utilityModel = Mage::getModel('utility/utility')->load($utilityId);
       	if ($utilityModel->getId() || $utilityId == 0)
       	{
       		/*$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$utilityModel->setData($data);
			}*/
         	Mage::register('utility_data', $utilityModel);
         	$this->loadLayout();
         	$this->_setActiveMenu('utility/set_time');
         	$this->_addBreadcrumb('utility Manager', 'utility Manager');
         	$this->_addBreadcrumb('Utility Description', 'Utility Description');
         	$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
         	$this->_addContent($this->getLayout()->createBlock('utility/adminhtml_utility_edit'))
              	->_addLeft($this->getLayout()->createBlock('utility/adminhtml_utility_edit_tabs'));
         	$this->renderLayout();
   		}
       	else
       	{
         	Mage::getSingleton('adminhtml/session')->addError('Utility does not exist');
         	$this->_redirect('*/*/');
        }
   	}
   	public function newAction()
   	{
      	$this->_forward('edit');
   	}
   	public function saveAction()
   	{
     	if ($this->getRequest()->getPost())
     	{
       		try {
             	$postData = $this->getRequest()->getPost();
             	$utilityModel = Mage::getModel('utility/utility');
           		if( $this->getRequest()->getParam('id') <= 0 )
       			{
              		$utilityModel->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
       			}
              	$utilityModel
                	->addData($postData)
                	->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
                	->setId($this->getRequest()->getParam('id'))
                	->save();
             	Mage::getSingleton('adminhtml/session')->addSuccess('successfully saved');
             	Mage::getSingleton('adminhtml/session')->setutilityData(false);
             	$this->_redirect('*/*/');
            	return;
      		} catch (Exception $e) {
            	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            	Mage::getSingleton('adminhtml/session')->setutilityData($this->getRequest()->getPost());
            	$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            	return;
            }
        }
      	$this->_redirect('*/*/');
    }
  	public function deleteAction()
  	{
      	if($this->getRequest()->getParam('id') > 0)
      	{
        	try
        	{
            	$utilityModel = Mage::getModel('utility/utility');
            	$utilityModel->setId($this->getRequest()->getParam('id'))->delete();
            	Mage::getSingleton('adminhtml/session')->addSuccess('successfully deleted');
            	$this->_redirect('*/*/');
         	}
         	catch (Exception $e)
          	{
               	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
               	$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
          	}
     	}
    	$this->_redirect('*/*/');
   	}

   	/**
     * export grid item to CSV type
     */
    public function exportCsvAction()
    {
        $fileName = 'utility.csv';
        $content = $this->getLayout()->createBlock('utility/adminhtml_utility_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export grid item to XML type
     */
    public function exportXmlAction()
    {
        $fileName = 'utility.xml';
        $content = $this->getLayout()->createBlock('utility/adminhtml_utility_grid')->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }
}