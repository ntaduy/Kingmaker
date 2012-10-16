<?php
/**
 * Kingmaker CMS, Show adminhtml grid block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Show_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('show_grid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('desc');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('kmcms/show')->getCollection();
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

		$this->addColumn('host_blurb', array(
				'header'    => Mage::helper('kmcms')->__('Blurb'),
				'align'     =>'left',
				'index'     => 'host_blurb'
		));

		$this->addColumn('host_id', array(
				'header'    => Mage::helper('kmcms')->__('Host ID'),
				'align'     => 'left',
				'index'     => 'host_id'
		));
		
		$this->addColumn('category', array(
				'header'    => Mage::helper('kmcms')->__('Category'),
				'align'     => 'left',
				'index'     => 'category'
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