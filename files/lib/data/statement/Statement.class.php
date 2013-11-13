<?php
namespace credits\data\statement;
use credits\data\CreditsDatabaseObject;

/**
 * Represents a credits statement entry.
 *
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
class Statement extends CreditsDatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'statement';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'statementID';
}
