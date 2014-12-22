<?php
  $installer = $this;
  $installer->startSetup();
 
  $installer->run("
    DROP TABLE IF EXISTS {$this->getTable('th_tweet')};
 
    CREATE TABLE {$this->getTable('th_tweet')} (
      `tweet_id` int(11) NOT NULL AUTO_INCREMENT,
      `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      `twitter_id` bigint(20) NOT NULL,
      `text` text NOT NULL,
      PRIMARY KEY (`tweet_id`)
    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1
  ");
 
  $installer->endSetup();