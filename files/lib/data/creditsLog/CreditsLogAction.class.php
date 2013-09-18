<?php
namespace wcf\data\creditsLog;
use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\exception\UserInputException;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\WCF;
use wcf\data\user\User;

/**
 * Executes credits log-related actions.
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CreditsLogAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'wcf\data\creditslog\CreditsLogEditor';

	/**
	 * Validates parameters to close conversations.
	 */
	public function validateCompressLog() {
		if (!isset($this->parameters['userID'])) {
			throw new UserInputException('userID');
		}

		if ($this->parameters['userID'] != WCF::getUser()->userID) {
			throw new PermissionDeniedException();
		}
	}

	/**
	 * "compress" log for given user
	 *
	 * @param int userID
	 */
	public function compressLog() {
		CreditsLogEditor::markDeletedForUser($this->parameters['userID']);

		$user = new User($this->parameters['userID']);

		$data = array(
			'userID' => $user->userID,
			'langvar' => 'wcf.credits.log.compress',
			'credits' => $user->credits,
			'time' => TIME_NOW
		);

		$objectAction = new CreditsLogAction(array(), 'create',
				array('data' => $data));
		$objectAction->executeAction();
	}
}
