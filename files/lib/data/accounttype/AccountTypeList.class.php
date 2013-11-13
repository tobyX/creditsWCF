<?php
namespace credits\data\accounttype;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of credits accounts.
 *
 * @author		Tobias Friebel
 * @copyright		2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class AccountTypeList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'credits\data\accounttype\AccountType';
}
