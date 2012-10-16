<?php
/**
 * Kingmaker CMS , Episode base helper
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */
class Kingmaker_Kmcms_Helper_HttpClient extends Mage_Core_Helper_Abstract
{
	public function doPost($url, $params)
	{
		$c = curl_init($url);
		curl_setopt($c, CURLOPT_POST, true);
		curl_setopt($c, CURLOPT_POSTFIELDS, $params);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($c);
		curl_close($c);
		
		return $res;
	}
	
	public function doGet($url, $params)
	{
		$queryStr = $url . '?' . $params;

		$c = curl_init($queryStr);
		curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$res = curl_exec($c);
		curl_close($c);
	
		return $res;
	}
}