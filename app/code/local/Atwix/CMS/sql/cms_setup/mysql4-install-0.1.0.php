<?php

$installer = $this;
$installer->startSetup();

$installer->run('
  ALTER TABLE  `cms_page` ADD  `content_custom` VARCHAR( 255 ) NULL;
');
var_dump(12345);exit();
$installer->endSetup();