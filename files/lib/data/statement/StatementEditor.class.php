<?php
namespace credits\data\statement;
use wcf\data\DatabaseObjectEditor;
use wcf\system\WCF;

/**
 * Extends the creditslog object with functions to create, update and delete log entries.
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class StatementEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectEditor::$baseClass
	 */
	protected static $baseClass = 'credits\data\statement\Statement';

	/**
	 * mark all entries deleted for given userID
	 *
	 * @param int userID
	 */
	public static function markDeletedForUser($userID) {
		$sql = "UPDATE 	credits".WCF_N."_statement
			SET 	deleted = 1
			WHERE 	userID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		$statement->execute(array(
				$userID
		));
	}
}
