<?php
/**
 * Kingmaker CMS, Show adminhtml content block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Show extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	protected $_addButtonLabel = 'Add New Show';

	public function __construct()
	{
		parent::__construct();
		$this->_controller = 'adminhtml_show';
		$this->_blockGroup = 'kmcms';
		$this->_headerText = Mage::helper('kmcms')->__('Shows');
	}
}