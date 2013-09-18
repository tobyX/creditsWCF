<?php
namespace wcf\system\cache\builder;
use wcf\system\WCF;

/**
 * Cache menustructure of creditspage
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CreditsMainpageCacheBuilder extends AbstractCacheBuilder {

	/**
	 * @see	wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	public function rebuild(array $parameters) {
		$data = array ();

		// get needed menu items and build item tree
		$sql = "SELECT		menu_item.*
				FROM		wcf" . WCF_N . "_credits_mainpage menu_item,
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
