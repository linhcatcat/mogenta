<?php
 
class Atwix_SystemConfig_Model_Observer
{
    /*public function changeSystemConfig(Varien_Event_Observer $observe)
    {
        $config = $observe->getConfig();
 
        return $this;
    }*/

    /*public function changeSystemConfig(Varien_Event_Observer $observer)
    {
        //get init sections and tabs
        $config = $observer->getConfig();
 
        //get tab 'advanced', change sort order and label
        $advancedTab = $config->getNode('tabs/advanced');
        $advancedTab->sort_order = 1;
        $advancedTab->label .= ' (on top)';
 
        //get field 'page', add comment
        $config->getNode('sections/admin/groups/startup/fields/page')->comment = 'after successful login you will see this page';
 
        return $this;
    }*/

    public function changeSystemConfig(Varien_Event_Observer $observer)
    {
        //get init sections and tabs
        $config = $observer->getConfig();
 
        //get tab 'advanced', change sort order and label
        $advancedTab = $config->getNode('tabs/advanced');
        $advancedTab->sort_order = 1;
        $advancedTab->label .= ' (on top)';
 
        //get field 'page', add comment
        $config->getNode('sections/admin/groups/startup/fields/page')->comment = 'after successful login you will see this page';
 
        //add new group with fields in section 'admin'
        $adminSectionGroups = $config->getNode('sections/admin/groups');
        $new_group_xml = new Mage_Core_Model_Config_Element('
            <atwix_new_group>
                <label>New Group</label>
                <sort_order>99</sort_order>
                <show_in_default>1</show_in_default>
                <show_in_website>1</show_in_website>
                <show_in_store>1</show_in_store>
                <fields>
                        <disable_message>
                            <label>Disable Message</label>
                            <frontend_type>select</frontend_type>
                            <source_model>adminhtml/system_config_source_yesno</source_model>
                            <sort_order>10</sort_order>
                            <show_in_default>1</show_in_default>
                            <show_in_website>1</show_in_website>
                            <show_in_store>1</show_in_store>
                        </disable_message>
                        <message>
                            <label>Message</label>
                            <frontend_type>text</frontend_type>
                            <sort_order>20</sort_order>
                            <show_in_default>1</show_in_default>
                            <show_in_website>1</show_in_website>
                            <show_in_store>1</show_in_store>
                            <depends>
                                <disable_message>0</disable_message>
                            </depends>
                        </message>
                </fields>
            </atwix_new_group>
        ');
        $adminSectionGroups->appendChild($new_group_xml);
 
        return $this;
    }
}