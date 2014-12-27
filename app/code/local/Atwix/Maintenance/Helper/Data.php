<?php
class Atwix_Maintenance_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * get store config data 'atwix/maintenance_settings/maintenance_enable'
     *
     * @return bool
     */
    public function isEnabeled ()
    {
        $enabel = Mage::getStoreConfig('atwix/maintenance_settings/maintenance_enable');
        return $enabel == 1 ? true : false;
    }
 
    /**
     * get store config data 'atwix/maintenance_settings/allow_ips'
     * and prepare allow IPs array
     *
     * @return array
     */
    public function getAllowIpsArray()
    {
        $ipArray = array();
        $string = Mage::getStoreConfig('atwix/maintenance_settings/allow_ips');
        if (isset($string)) {
            $ipArray = explode(',', $string);
        }
        return $ipArray;
    }
}