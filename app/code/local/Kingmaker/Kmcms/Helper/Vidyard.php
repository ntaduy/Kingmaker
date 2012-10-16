<?php
/**
 * Kingmaker CMS , Episode base helper
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */
class Kingmaker_Kmcms_Helper_Vidyard extends Mage_Core_Helper_Abstract
{
	const URL_API_PLAYERS = "https://api.vidyard.com/dashboard/v1/players";
	const URL_API_VIDEOS = "https://api.vidyard.com/dashboard/v1/videos";
	const API_RESPONSE_FORMAT = ".json";
	const API_AUTH_TOKEN = "pvfryKpLmeGzptDRspVS";
	
	public function getVideo($id)
	{
		$url = $this::URL_API_VIDEOS . '/' . $id . $this::API_RESPONSE_FORMAT;
		$params = 'auth_token=' . $this::API_AUTH_TOKEN;
		
		$res = Mage::helper('kmcms/httpclient')->doGet($url, $params);
		
		return Zend_Json::decode($res);
	}
}