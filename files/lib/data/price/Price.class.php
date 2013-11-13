<?php
namespace credits\data\price;
use credits\data\CreditsDatabaseObject;

/**
 * Represents a credits price.
 *
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
class Price extends CreditsDatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'price';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'priceID';
}
