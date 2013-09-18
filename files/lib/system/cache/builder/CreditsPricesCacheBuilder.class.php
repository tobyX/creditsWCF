<?php
namespace wcf\system\cache\builder;
use wcf\system\WCF;

/**
 * Cache prices of credits actions
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CacheBuilderGuthabenPrices extends AbstractCacheBuilder {

	/**
	 * @see	wcf\system\cache\builder\AbstractCacheBuilder::rebuild()
	 */
	public function rebuild(array $parameters) {
		$data = array ();

		$sql = "SELECT		prices.*
				FROM		wcf" . WCF_N . "_guthaben_prices prices,
							wcf" . WCF_N . "_package_dependency package_dependency
				WHERE		prices.packageID = package_dependency.dependency
							AND package_dependency.packageID = ".PACKAGE_ID;

		$statement = WCF::getDB()->prepareStatement($sql);

		while ($row = $statement->fetchArray()) {
			$data[] = $row;
		}

		return $data;
	}
}
