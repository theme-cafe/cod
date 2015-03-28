<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('cod')};
CREATE TABLE {$this->getTable('cod')} (
  `cod_id` int(11) unsigned NOT NULL auto_increment,
  `area` varchar(264) NOT NULL default '',
  `cityname` varchar(264) NOT NULL default '',
  `state` varchar(264) NOT NULL default '',
  `pincode` int(10) unsigned NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  PRIMARY KEY (`cod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();
