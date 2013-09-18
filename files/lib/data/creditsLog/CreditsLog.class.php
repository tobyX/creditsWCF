<?php
namespace wcf\data\creditsLog;
use wcf\data\DatabaseObject;

/**
 * Represents a credits log entry.
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CreditsLog extends DatabaseObject {
	/**
	 * @see	wcf\data\DatabaseObject::$databaseTableName
	 */
	protected static $databaseTableName = 'credits_log';

	/**
	 * @see	wcf\data\DatabaseObject::$databaseIndexName
	 */
	protected static $databaseTableIndexName = 'logID';
}
