<?php
/**
 * Kingmaker CMS, Episode page model
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Model_Episode extends Mage_Core_Model_Abstract
{
	protected function _construct()
	{
		parent::_construct();
		$this->_init('kmcms/episode');
	}
}
