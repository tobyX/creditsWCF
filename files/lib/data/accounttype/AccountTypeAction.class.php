<?php
namespace credits\data\accounttype;
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Executes credits account-related actions.
 *
 * @author		Tobias Friebel
 * @copyright		2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class AccountTypeAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'credits\data\accounttype\AccountTypeEditor';
}
