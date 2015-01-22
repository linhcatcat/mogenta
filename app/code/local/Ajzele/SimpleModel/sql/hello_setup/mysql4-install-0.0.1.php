<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$baseTableName = 'ajzele_hello';

$sql = "
SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `hello`
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable($baseTableName)};
CREATE TABLE {$this->getTable($baseTableName)} (
  `hello_id` int(11) NOT NULL AUTO_INCREMENT,
  `field1` varchar(255) DEFAULT NULL,
  `field2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`hello_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
";

$installer->run($sql);

$installer->endSetup();