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

require_once (WCF_DIR . 'lib/acp/package/plugin/AbstractXMLPackageInstallationPlugin.class.php');

class GuthabenPricesPackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin
{
	public $tagName = 'guthabenprices';
	public $tableName = 'guthaben_prices';

	/**
	 * @see PackageInstallationPlugin::install()
	 */
	public function install ()
	{
		parent :: install();
		
		if (!$xml = $this->getXML())
		{
			return;
		}
		
		// Create an array with the data blocks (import or delete) from the xml file.
		$headerMenuXML = $xml->getElementTree('data');
		
		// Loop through the array and install or uninstall items.
		foreach ($headerMenuXML['children'] as $block)
		{
			if (count($block['children']))
			{
				// Handle the import instructions
				if ($block['name'] == 'import')
				{
					// Loop through items and create or update them.
					foreach ($block['children'] as $item)
					{
						// Extract item properties.
						foreach ($item['children'] as $child)
						{
							if (!isset($child['cdata']))
								continue;
								
							$item[$child['name']] = $child['cdata'];
						}
						
						// check required attributes
						if (!isset($item['attrs']['name']))
						{
							throw new SystemException("Required 'name' attribute for header menu item tag is missing.", 13023);
						}
						
						// default values
						$priceItem = $priceConstant = $priceDescription = $priceCurrency = '';
						$isnegative = 0;
						
						// get values
						$priceItem = $item['attrs']['name'];
						$priceConstant = $item['price'];
						
						if (isset($item['description']))
							$priceDescription = $item['description'];
							
						if (isset($item['isnegative']))
							$isnegative = $item['isnegative'];
							
						if (isset($item['currency']))
							$priceCurrency = $item['currency'];
						
						// Insert or update items. 
						// Update through the mysql "ON DUPLICATE KEY"-syntax. 
						$sql = "INSERT INTO	wcf" . WCF_N . "_".$this->tableName." 
											(packageID, priceItem, priceDescription, priceConstant, priceIsNegative, priceCurrency)
								VALUES		(" . $this->installation->getPackageID() . ",
											'" . escapeString($priceItem) . "',
											'" . escapeString($priceDescription) . "',
											'" . escapeString($priceConstant) . "',
											".intval($isnegative).",
											'" . escapeString($priceCurrency) . "')
								ON DUPLICATE KEY UPDATE
											priceDescription = VALUES(priceDescription),
											priceConstant = VALUES(priceConstant),
											priceIsNegative = VALUES(priceIsNegative),
											priceCurrency = VALUES(priceCurrency)";
						WCF :: getDB()->sendQuery($sql);
					}
				} 
				elseif ($block['name'] == 'delete' && $this->installation->getAction() == 'update')
				{
					// Loop through items and delete them.
					$itemNames = '';
					foreach ($block['children'] as $menuItem)
					{
						// check required attributes
						if (!isset($menuItem['attrs']['name']))
						{
							throw new SystemException("Required 'name' attribute for header menu item tag is missing.", 13023);
						}
						// Create a string with all item names which should be deleted (comma seperated).
						if (!empty($itemNames))
							$itemNames .= ',';
						$itemNames .= "'" . escapeString($menuItem['attrs']['name']) . "'";
					}
					
					// Delete items.
					if (!empty($itemNames))
					{
						$sql = "DELETE FROM	wcf" . WCF_N . "_".$this->tableName." 
								WHERE		packageID = " . $this->installation->getPackageID() . "
											AND priceItem IN (" . $itemNames . ")";
						WCF :: getDB()->sendQuery($sql);
					}
				}
			}
		}
	}
	
	public function uninstall() 
	{
		parent::uninstall();
		
		// clear cache immediately
		WCF::getCache()->clear(WCF_DIR.'cache', 'cache.guthabenPrices-*.php');
	}
}
?>