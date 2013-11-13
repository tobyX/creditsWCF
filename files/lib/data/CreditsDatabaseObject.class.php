<?php
namespace credits\data;
use wcf\data\DatabaseObject;

/**
 * Abstract class for Credits data holder classes.
 *
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
abstract class CreditsDatabaseObject extends DatabaseObject {
	/**
	 * @see	\wcf\data\IStorableObject::getDatabaseTableName()
	 */
	public static function getDatabaseTableName() {
		return 'credits'.WCF_N.'_'.static::$databaseTableName;
	}
}
