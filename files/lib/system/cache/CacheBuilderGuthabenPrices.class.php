<?php
/*
 * +-----------------------------------------+
 * | Copyright (c) 2008 Tobias Friebel       |
 * +-----------------------------------------+
 * | Authors: Tobias Friebel <TobyF@Web.de>	 |
 * +-----------------------------------------+
 * 
 * CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 * 
 * $Id$
 */

require_once (WCF_DIR . 'lib/system/cache/CacheBuilder.class.php');

class CacheBuilderGuthabenPrices implements CacheBuilder
{
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData ($cacheResource)
	{
		$data = array ();
		
		$sql = "SELECT		prices.*
				FROM		wcf" . WCF_N . "_guthaben_prices prices,
							wcf" . WCF_N . "_package_dependency package_dependency
				WHERE		prices.packageID = package_dependency.dependency
							AND package_dependency.packageID = ".PACKAGE_ID;
		
		$result = WCF :: getDB()->sendQuery($sql);
		
		while ($row = WCF :: getDB()->fetchArray($result))
		{
			$data[] = $row;
		}
		
		return $data;
	}
}
?>