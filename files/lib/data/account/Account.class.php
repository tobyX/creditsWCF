<?php
namespace credits\data\account;
use credits\data\CreditsDatabaseObject;

/**
 * Represents a credits account entry.
 *
 * @author		Tobias Friebel
 * @copyright		2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class Account extends CreditsDatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'account';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'accountID';
}
