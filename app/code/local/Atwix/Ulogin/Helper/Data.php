<?php
class Atwix_Ulogin_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Gets allowed ip-addresses from configuration
     * @return array
     */
    public function getAllowedIps()
    {
        $ipsList = array();
        $ipsText = '127.0.0.1, 181.40.55.32'; // Comma separated list of allowed IP 
        $ipsList = explode(',', $ipsText);
        $ipsList = array_map('trim', $ipsList);
         
        return $ipsList;
    }
    /**
     * Checks if remote ip is allowed
     * @param array $allowedList
     * @return bool
     */
    public function checkAllowedIp($allowedList)
    {
        if (count($allowedList) > 0) {
            $remoteIp = Mage::helper('core/http')->getRemoteAddr();
            if (in_array($remoteIp, $allowedList))
                return true;
        }
        return false;
    }
}