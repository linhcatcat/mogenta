<?php
class Atwix_Maintenance_Model_Observer extends Varien_Event_Observer
{
    public function switchStoreToMaintenance()
    {
        $myIp = $_SERVER['REMOTE_ADDR'];
 
        $maintenanceOff = MAGENTO_ROOT . '/maintenance.off';
 
        $isEnable = Mage::helper('atwix_maintenance')->isEnabeled();
        $allowedIps = Mage::helper('atwix_maintenance')->getAllowIpsArray();
 
        if ($isEnable === true && !in_array($myIp, $allowedIps) && !file_exists($maintenanceOff)) {
 
        echo '<div style="margin: auto; width: 800px;">
                 <div style="margin: auto; width: 400px; font-size: 25px" >Service Temporarily Unavailable</div>
                 <div style="font-size: 14px">The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.</div>
              </div>';
 
        exit;
        }
    }
}