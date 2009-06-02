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

class CacheBuilderGuthabenMainpage implements CacheBuilder
{
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData ($cacheResource)
	{
		$data = array ();
		
		// get needed menu items and build item tree
		$sql = "SELECT		menu_item.*
				FROM		wcf" . WCF_N . "_guthaben_mainpage menu_item,
							wcf" . WCF_N . "_package_dependency package_dependency
				WHERE		menu_item.packageID = package_dependency.dependency
							AND package_dependency.packageID = ".PACKAGE_ID."
				ORDER BY	menu_item.showOrder";
		
		$result = WCF :: getDB()->sendQuery($sql);
		
		while ($row = WCF :: getDB()->fetchArray($result))
		{
			if (empty($row['parentMenuItem']))
			{
				$data['parents'][] = $row;
				
				if (!isset($data['items'][$row['menuItemLink']]))
					$data['items'][$row['menuItemLink']] = array();
			}
			else
			{
				$data['items'][$row['parentMenuItem']][] = $row;
			}
		}
		
		//remove empty tabs
		foreach ($data['parents'] as $id => $parent)
		{
			if (count($data['items'][$parent['menuItemLink']]) == 0)
				unset($data['parents'][$id]);
		}
		
		return $data;
	}
}
?>