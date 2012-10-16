<?php
/**
 * Kingmaker CMS, Episode mysql resource
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Model_Mysql4_Episode extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct()
	{
		$this->_init('kmcms/episode', 'id');
	}
}
