<?php
/**
 * Kingmaker CMS, Episode mysql table setup
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'kmcms/episode'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('kmcms/episode'))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
    ), 'Episode ID')
    ->addColumn('video_id', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
        'nullable'  => false
    ), 'Video ID')
    ->addColumn('video_player_uuid', Varien_Db_Ddl_Table::TYPE_TEXT, 100, array(
    	'nullable'  => false
    ), 'Embedded Player ID for the Video')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false
	), 'Episode Title')
    ->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
	), 'URL Key')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        'nullable'  => false,
	), 'Episode Description')
    ->addColumn('directions', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
	), 'Episode Step-by-step Directions')
     ->addColumn('show_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false
	), 'Show ID')
    ->addColumn('publish_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
	), 'Publish On')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
	), 'Is Episode Active')
    ->setComment('Kingmaker CMS Episode Table');
    
$installer->getConnection()->createTable($table);

/**
 * Create table 'kmcms/show'
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('kmcms/show'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'nullable'  => false,
		'primary'   => true,
	), 'Show ID')
	->addColumn('host_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable'  => false
	), 'Host ID')
	->addColumn('host_blurb', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
			'nullable'  => false
	), 'Host Blurb')
	->addColumn('category', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			'nullable'  => false,
	), 'Host Category')
	->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
		'nullable'  => false,
		'default'   => '1',
	), 'Is Show Active')
	->setComment('Kingmaker CMS Show Table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
