<?php
/**
 * Kingmaker CMS, Episode adminhtml grid block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Episode_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('episode_grid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('desc');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('kmcms/episode')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
				'header'    => Mage::helper('kmcms')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'id'
		));

		$this->addColumn('title', array(
				'header'    => Mage::helper('kmcms')->__('Title'),
				'align'     =>'left',
				'index'     => 'title'
		));

		$this->addColumn('description', array(
				'header'    => Mage::helper('kmcms')->__('Description'),
				'align'     =>'left',
				'index'     => 'description'
		));

		$this->addColumn('video_id', array(
				'header'    => Mage::helper('kmcms')->__('Video ID'),
				'align'     => 'left',
				'index'     => 'video_id'
		));
		
		$this->addColumn('url_key', array(
				'header'    => Mage::helper('kmcms')->__('URL Key'),
				'align'     => 'left',
				'index'     => 'url_key'
		));
		
		$this->addColumn('directions', array(
				'header'    => Mage::helper('kmcms')->__('Directions'),
				'align'     => 'left',
				'index'     => 'directions'
		));
		
		$this->addColumn('show_id', array(
				'header'    => Mage::helper('kmcms')->__('Show ID'),
				'align'     => 'left',
				'index'     => 'show_id'
		));
		
		$this->addColumn('publish_time', array(
				'header'    => Mage::helper('kmcms')->__('Publish On'),
				'align'     => 'left',
				'index'     => 'publish_time'
		));
		
		$this->addColumn('is_active', array(
				'header'    => Mage::helper('kmcms')->__('Active'),
				'align'     => 'right',
				'index'     => 'is_active'
		));

		return parent::_prepareColumns();
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}