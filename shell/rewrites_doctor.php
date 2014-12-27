<?php
/**
 * Atwix
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com<script cf-hash="f9e31" type="text/javascript">
 * @category    Atwix Mod
 * @package     Atwix_Mod
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
require_once 'abstract.php';
 
class Atwix_Shell_Rewrites_Doctor extends Mage_Shell_Abstract
{
    const PAGE_SIZE = 1000;
    const LOG_MESSAGE_ROWS = 100;
 
    public function run()
    {
        if($left = $this->getArg('remove_rewrites')){
            $this->clearExtraRewrites($left);
        } elseif($this->getArg('update_keys')) {
            $this->updateDuplicatedKeys();
        } elseif($this->getArg('remove_sku_spaces')) {
            $this->removeSkuSpaces();
        } else {
            echo $this->usageHelp();
        }
    }
 
    /**
     * Update duplicated url keys by adding product SKU to the duplicated key
     */
    public function updateDuplicatedKeys()
    {
        try {
            $counter = 0;
            $logMessage = '';
            $start = time();
            $storeId = Mage::app()->getStore()->getId() . PHP_EOL;
 
            //url key attriubte load for further use
            $entityType = Mage::getModel('eav/entity_type')->loadByCode('catalog_product');
            $attributes = $entityType->getAttributeCollection()
                ->addFieldToFilter('attribute_code', array('eq' => 'url_key'))
            ;
            $urlKeyAttribute = $attributes->getFirstItem();
            $urlKeyAttributeTable = $attributes->getTable($entityType->getEntityTable());
 
            //loading collection with number of duplicated url keys
            $duplicatesCollection = Mage::getModel('catalog/product')->getCollection();
            $duplicatesCollection->getSelect()
                ->joinLeft(
                    array('url_key' => $urlKeyAttributeTable . '_' . $urlKeyAttribute->getBackendType()),
                    'e.entity_id' . ' = url_key.entity_id AND url_key.attribute_id = ' . $urlKeyAttribute->getAttributeId() . ' AND url_key.store_id = ' . $storeId,
                    array($urlKeyAttribute->getAttributeCode() => 'url_key.value')
                )
                ->columns(array('duplicates_calculated' => new Zend_Db_Expr ('COUNT(`url_key`.`value`)')))
                ->group('url_key.value')
                ->order('duplicates_calculated DESC')
            ;
 
            foreach($duplicatesCollection as $item) {
                if($item->getData('duplicates_calculated') > 1) {
                    //loading product ids with duplicated url keys
                    $duplicatedUrlKey = $item->getData('url_key');
                    $productCollection = Mage::getModel('catalog/product')->getCollection()
                        ->addAttributeToSelect('url_key')
                        ->addAttributeToFilter('url_key', array('eq' => $duplicatedUrlKey))
                    ;
                    $ids = $productCollection->getAllIds();
 
                    foreach($ids as $id){
                        try {
                            //update product url key
                            $product = Mage::getModel('catalog/product')->load($id);
                            $sku = $product->getData('sku');
                            $urlKey = $product->getData('url_key');
                            $product->setData('url_key', $urlKey . '-' . strtolower(str_replace(' ', '-', $sku)));
                            $product->save();
                            $counter++;
                            $message = 'Product id# ' . $product->getId() . ' "' . $product->getName() . '" ' . ' url key was changed from "' . $urlKey . '" to "' . $product->getData('url_key') . '"' . PHP_EOL;
                            $logMessage .= $message;
                            //log will be update with the packs of messages
                            if($counter % self::LOG_MESSAGE_ROWS == 0) {
                                Mage::log($logMessage, null, 'atwix_rewrites_doctor.log', true);
                                $logMessage = '';
                            }
                            echo $message;
                        } catch (Exception $e) {
                            echo $e->getMessage() . PHP_EOL;
                            Mage::log($e->getMessage(), null, 'atwix_rewrites_doctor.log', true);
                        }
                    }
                } else {
                    //we will break the cycle after all duplicates in query were processed
                    break;
                }
            }
 
            if($counter % self::LOG_MESSAGE_ROWS != 0) {
                Mage::log($logMessage, null, 'atwix_rewrites_doctor.log', true);
            }
 
            $end = time();
            $message = $counter . ' products were updated, time spent: ' . $this->timeSpent($start, $end);
            Mage::log($message, null, 'atwix_rewrites_doctor.log', true);
            echo $message . PHP_EOL;
 
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
            Mage::log($e->getMessage(), null, 'atwix_rewrites_doctor.log', true);
        }
    }
 
    /**
     * Remove extra product url rewrites leaving $left of last
     *
     * @var $left
     */
    public function clearExtraRewrites($left)
    {
        try {
            $start = time();
            //Get product collection
            $productCollection = Mage::getModel('catalog/product')->getCollection();
            $productCollection->setPageSize(self::PAGE_SIZE);
            $pages = $productCollection->getLastPageNumber();
            $currentPage = 1;
            $counter = 0;
 
            while($currentPage <= $pages) {
                $productCollection->setCurPage($currentPage);
                $productCollection->load();
 
                $ids = $productCollection->getAllIds();
                foreach($ids as $id) {
                    //get rewrites collection for current product id
                    $urlRewritesCollection = Mage::getModel('core/url_rewrite')->getCollection()
                        ->addFieldToFilter('product_id', array('eq' => $id))
                        ->addFieldToFilter('is_system', array('eq' => '0'))
                        ->setOrder('url_rewrite_id', 'DESC')
                    ;
                    $urlRewritesCollection->getSelect()->limit(null, $left);
 
                    foreach($urlRewritesCollection as $urlRewrite) {
                        try {
                            $urlRewrite->delete();
                            $counter++;
                        } catch(Exception $e) {
                            echo "An error was occurred: " . $e->getMessage() . PHP_EOL;
                            Mage::log($e->getMessage(), null, 'atwix_rewrites_doctor.log', true);
 
                        }
                    }
                }
 
                echo $counter . " URL rewrites were deleted" . PHP_EOL;
                $currentPage++;
                $productCollection->clear();
            }
 
            $end = time();
            $message = 'Total URL rewrites deleted: ' . $counter . ', time spent: ' . $this->timeSpent($start, $end);
            Mage::log($message, null, 'atwix_rewrites_doctor.log', true);
            echo $message . PHP_EOL;
 
        } catch (Exception $e) {
            echo "An error was occurred: " . $e->getMessage() . PHP_EOL;
            Mage::log($e->getMessage(), null, 'atwix_rewrites_doctor.log', true);
        }
    }
 
    public function removeSkuSpaces()
    {
        try {
            $start = time();
            $counter = 0;
            $logMessage = '';
            //Get product collection with skus which contain spaces
            $productCollection = Mage::getModel('catalog/product')->getCollection()
                ->addFieldToFilter('sku', array('like' => '% %'))
            ;
            $productCollection->setPageSize(self::PAGE_SIZE);
            $pages = $productCollection->getLastPageNumber();
            $currentPage = 1;
            while($currentPage <= $pages) {
                $productCollection->setCurPage($currentPage);
                $productCollection->load();
 
                foreach($productCollection as $product) {
                    try {
                        $sku = $product->getSku();
                        $newSku = str_replace(' ', '', $sku);
                        $product->setData('sku', $newSku);
                        $product->save();
                        $counter++;
                        $message = 'Product id# ' . $product->getId() . ' sku was changed from "' . $sku . '" to "' . $newSku . '"' . PHP_EOL;
                        $logMessage .= $message;
                        //log will be update with the packs of messages
                        if($counter % self::LOG_MESSAGE_ROWS == 0) {
                            Mage::log($logMessage, null, 'atwix_rewrites_doctor.log', true);
                            $logMessage = '';
                        }
                        echo $message;
                    } catch (Exception $e) {
                        echo $e->getMessage() . PHP_EOL;
                        Mage::log($e->getMessage(), null, 'atwix_rewrites_doctor.log', true);
                    }
                }
 
                $currentPage++;
                $productCollection->clear();
            }
            if($counter % self::LOG_MESSAGE_ROWS != 0) {
                Mage::log($logMessage, null, 'atwix_rewrites_doctor.log', true);
            }
            $end = time();
            $message = 'Total SKUs updated: ' . $counter . ', time spent: ' . $this->timeSpent($start, $end);
            Mage::log($message, null, 'atwix_rewrites_doctor.log', true);
            echo $message . PHP_EOL;
        } catch (Exception $e) {
            echo "An error was occurred: " . $e->getMessage() . PHP_EOL;
            Mage::log($e->getMessage(), null, 'atwix_rewrites_doctor.log', true);
        }
    }
 
    public function timeSpent($start, $end)
    {
        $seconds = $end - $start;
        $hours = floor($seconds / 3600);
        $mins = floor(($seconds - ($hours*3600)) / 60);
        $secs = floor($seconds % 60);
 
        return $hours . ' hours ' . $mins . ' minutes ' . $secs . ' seconds';
    }
 
    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
 
Usage:  php -f fix_attributes -- [options]
 
    --remove_rewrites number    Remove old product rewrites, leaving the 'number' of last ones
    update_keys                 Update duplicated product keys
    remove_sku_spaces           Remove space from all product SKU's if they are present
 
    help                        This help
 
USAGE;
    }
}
 
$shell = new Atwix_Shell_Rewrites_Doctor();
$shell->run();

//php shell/rewrites_doctor.php update_keys
//php shell/indexer.php --reindex url_redirect
//php shell/rewrites_doctor.php --remove_rewrites 4