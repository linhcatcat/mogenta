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
  public function testAction()
  {
    $this->_initAction();
    $this->renderLayout();
  }

  /**
     * Import action, import group price from csv
     */
    public function importAction()
    {
        $fileTrue = $this->fileImportCsvUpload();
        if ($fileTrue == true) {
            $file = 'var/importexport/example.csv';
            $csv = new Varien_File_Csv();
            $data = $csv->getData($file);
            unset($data[0]);
            foreach ($data as $value) {
                $productId = $value[0];
 
                $product = Mage::getModel('catalog/product')->setStoreId(0)->load($productId);
                 
                if ($product == false || !$product->getSku()) {
                    continue;
                }
                $pricesFilterKeys = array('price_id', 'all_groups', 'website_price');
 
                $groupPrice = $product->getData('group_price');
                $key = count($groupPrice);
                $groupPrice[$key+1]['website_id'] = $value[1];
                $groupPrice[$key+1]['cust_group'] = $value[2];
                $groupPrice[$key+1]['price'] = $value[3];
 
                $product->setData('group_price', $this->_filterOutArrayKeys($groupPrice, $pricesFilterKeys, true));
 
                $product->save();
            }
            Mage::getSingleton('core/session')->addSuccess("Import success");
        } else {
            Mage::getSingleton('checkout/session')->addError("Import is failed.");
        }
 
        $this->_redirect("*/*/index");
    }
 
    /**
     * Remove specified keys from array
     *
     * @param array $array
     * @param array $keys
     * @param bool $dropOrigKeys if true - return array as indexed array
     * @return array
     */
    protected function _filterOutArrayKeys(array $array, array $keys, $dropOrigKeys = false)
    {
        $isIndexedArray = is_array(reset($array));
        if ($isIndexedArray) {
            foreach ($array as &$value) {
                if (is_array($value)) {
                    $value = array_diff_key($value, array_flip($keys));
                }
            }
            if ($dropOrigKeys) {
                $array = array_values($array);
            }
            unset($value);
        } else {
            $array = array_diff_key($array, array_flip($keys));
        }
 
        return $array;
    }
 
    /**
     * Upload csv file and save in var/importexport/example.csv
     *
     * @return bool
     */
    public function fileImportCsvUpload()
    {
        if (isset($_FILES['import_file']['name']) and (file_exists($_FILES['import_file']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('import_file');
                $uploader->setAllowedExtensions(array('csv')); // or pdf or anything
 
 
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
 
                $path = Mage::getBaseDir('var') . DS .'importexport' . DS;
 
                $uploader->save($path, $_FILES['fileinputname']['name'] = 'example.csv');
 
                $data['fileinputname'] = $_FILES['fileinputname']['name'];
                return true;
            }catch(Exception $e) {
                Mage::getSingleton('core/session')->addError("File extension is not supported!");
            }
        }
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