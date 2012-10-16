<?php
/**
 * Kingmaker CMS, Episode mysql table setup
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */
 
$installer = $this;
 
$installer->startSetup();

/**
 * Create table 'kmcms/episode'
 */
$installer->run("
 
-- 	DROP TABLE IF EXISTS {$this->getTable('kingmaker_kmcms_episode')};
	CREATE TABLE {$this->getTable('kingmaker_kmcms_episode')} (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Episode ID',
		`video_id` varchar(100) NOT NULL COMMENT 'Video ID',
		`video_player_uuid` varchar(100) NOT NULL COMMENT 'Embedded Player ID for the Video',
		`title` varchar(255) NOT NULL COMMENT 'Episode Title',
		`url_key` varchar(255) NOT NULL COMMENT 'URL Key',	
		`description` text NOT NULL COMMENT 'Episode Description',
		`directions` mediumtext NOT NULL COMMENT 'Episode Step-by-step Directions',
		`show_id` int(11) unsigned NOT NULL COMMENT 'Show ID',
		`publish_time` timestamp NOT NULL COMMENT 'Publish On',
		`is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Episode Active',
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Kingmaker CMS Episode Table' AUTO_INCREMENT=1 ;
 
");

/**
 * Create table 'kmcms/show'
 */
$installer->run("

-- 	DROP TABLE IF EXISTS {$this->getTable('kingmaker_kmcms_show')};
	CREATE TABLE {$this->getTable('kingmaker_kmcms_show')} (
		`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Show ID',
		`host_id` int(11) unsigned NOT NULL COMMENT 'Host ID',
		`host_blurb` varchar(50) NOT NULL COMMENT 'Host Blurb',
		`category` varchar(255) NOT NULL COMMENT 'Show Category',
		`is_active` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Is Show Active',
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Kingmaker CMS Show Table' AUTO_INCREMENT=1 ;

");
 
$installer->endSetup();