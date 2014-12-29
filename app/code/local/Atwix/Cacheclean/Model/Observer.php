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
 * to license@magentocommerce.com so we can send you a copy immediately.

 * @category    Atwix Mod
 * @package     Atwix_Cacheclean
 * @author      Atwix Core Team
 * @copyright   Copyright (c) 2014 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Atwix_Cacheclean_Model_Observer extends Varien_Event_Observer
{
    /**
     * Removes all cache entries from the file system
     */
    public function cleanFullPageCache()
    {
        $fpcDir = Mage::getConfig()->getVarDir('full_page_cache');
        $cacheDir = Mage::getConfig()->getVarDir('cache');
        if (file_exists($fpcDir)) {
            try {
                Mage::helper('atwix_cacheclean')->Cleandir($fpcDir);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
        if (file_exists($cacheDir)) {
            try {
                Mage::helper('atwix_cacheclean')->Cleandir($cacheDir);
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }
}