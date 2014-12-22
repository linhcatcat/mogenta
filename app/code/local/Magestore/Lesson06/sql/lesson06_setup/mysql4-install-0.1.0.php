<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * create lesson06 table
 */
$installer->run("

DROP TABLE IF EXISTS {$this->getTable('lesson06')};

CREATE TABLE {$this->getTable('lesson06')} (
  `lesson06_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`lesson06_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup();

