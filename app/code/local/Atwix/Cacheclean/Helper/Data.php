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
 * @copyright   Copyright (c) 2012 Atwix (http://www.atwix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Atwix_Cacheclean_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Cleans directory contents
     *
     * @param string $path
     */
    public function Cleandir($path)
    {
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && is_file($path.'/'.$file)) {
                    if (unlink($path.'/'.$file)) { }
                    else {
                        Mage::log($path . '/' . $file . ' file was not removed', null, 'system.log');
                    }
                }
                else if ($file != '.' && $file != '..' && is_dir($path.'/'.$file)) {
                    $this->Cleandir($path.'/'.$file);
                    if (rmdir($path.'/'.$file)) { }
                    else {
                        Mage::log($path . '/' . $file . ' directory was not removed', null, 'system.log');
                    }
                }
            }
            closedir($handle);
        }
    }
}