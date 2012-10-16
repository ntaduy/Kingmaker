<?php
/**
 * Kingmaker CMS, Episode adminhtml content block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Episode extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	protected $_addButtonLabel = 'Add New Episode';

	public function __construct()
	{
		parent::__construct();
		$this->_controller = 'adminhtml_episode';
		$this->_blockGroup = 'kmcms';
		$this->_headerText = Mage::helper('kmcms')->__('Episodes');
	}
}