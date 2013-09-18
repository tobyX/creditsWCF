<?php
namespace wcf\data\creditsLog;
use wcf\data\DatabaseObjectEditor;
use wcf\system\WCF;

/**
 * Extends the conversation object with functions to create, update and delete conversations.
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CreditsLogEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectEditor::$baseClass
	 */
	protected static $baseClass = 'wcf\data\creditslog\CreditsLog';

	/**
	 * mark all entries deleted for given userID
	 *
	 * @param int userID
	 */
	public static function markDeletedForUser($userID) {
		$sql = "UPDATE 	wcf".WCF_N."_credits_log
				SET 	deleted = 1
				WHERE 	userID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(
				$userID
		));
	}
}
