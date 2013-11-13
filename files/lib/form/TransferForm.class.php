<?php
namespace credits\form;
use wcf\data\user\UserProfile;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;
use wcf\util\CreditsUtil;
use wcf\system\credits\CreditsHandler;
use wcf\form\AbstractForm;
use wcf\system\request\LinkHandler;

/**
 * Shows the transfer credits form
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class TransferForm extends AbstractForm
{
	/**
	 * @see	wcf\page\AbstractPage::$enableTracking
	 */
	public $enableTracking = true;

	/**
	 * @see	wcf\page\AbstractPage::$neededPermissions
	 */
	public $neededPermissions = array('credits.canuse',
					  'credits.transfer.canuse');

	/**
	 * user id
	 * @var	integer
	 */
	public $senderID = 0;

	/**
	 * credits to transfer
	 * @var	string
	 */
	public $transfer = 0.0;

	/**
	 * transfer message, will be displayed in credits log
	 * @var	string
	 */
	public $text = '';

	/**
	 * recipient of transfer
	 * @var	string
	 */
	public $recipientName = '';

	/**
	 * recipient of transfer
	 * @var	string
	 */
	public $recipient;

	/**
	 * moderators can send/subtract money from anybody
	 * @var	string
	 */
	public $moderativ = false;

	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent :: readFormParameters();

		if (isset ($_POST['recipient']))
			$this->recipientName = StringUtil :: trim($_POST['recipient']);

		if (isset ($_POST['credits']))
			$this->credits = abs(floatval($_POST['credits']));

		if (isset ($_POST['text']))
			$this->text = StringUtil :: trim($_POST['text']);

		if (isset ($_POST['moderativ']))
			$this->moderativ = (bool) $_POST['moderativ'];
	}

	/**
	 * @see Form::validate()
	 */
	public function validate() {
		parent::validate();

		$this->recipient = $this->validateRecipient($this->recipient);

		if (!WCF::getUser()->getPermission('credits.moderation.cantransfer'))
			$this->moderativ = false;

		if ($this->transfer == 0)
			throw new UserInputException('transfer', 'empty');

		if (CreditsUtil::get(true) < $this->transfer && !$this->moderativ)
			throw new UserInputException('transfer', 'tomutch');
	}

	/**
	 * Checks the given recipients.
	 */
	protected function validateRecipient() {
		if (empty($this->recipientName))
			throw new UserInputException('recipient', 'empty');

		// get recipient's profile
		$recipient = UserProfile::getUserProfilesByUsername(
				$this->recipientName);
		if (!$recipient->userID)
			throw new UserInputException('recipient',
					array('type' => 'notFound',
						  'username' => $this->recipientName));

		// active user is ignored by recipient
		if ($recipient->ignoredUser)
			throw new UserInputException('recipient',
					array('type' => 'ignoresYou',
						  'username' => $this->recipientName));

		if (!$recipient->getPermission('credits.transfer.canreceive') ||
			!$recipient->getPermission('credits.canuse'))
			throw new UserInputException('recipient',
					array('type' => 'cannotReceive',
						  'username' => $this->recipientName));

		return $recipient;
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables() {
		parent :: assignVariables();

		WCF :: getTPL()->assign(array (
			'recipient' => $this->recipient,
			'transfer' => $this->transfer,
			'text' => $this->text,
			'moderativ' => $this->moderativ,
		));
	}

	/**
	 * @see Form::save()
	 */
	public function save() {
		parent::save();

		if ($this->moderativ) {
			if (intval($_POST['transfer']) < 0)
				CreditsHandler::getInstance()->subtract($this->credits,
						'wcf.credits.log.moderativ',
						WCF::getUser()->username.': '.$this->text, '',
						$this->recipient);
			else
				CreditsHandler::getInstance()->add($this->credits,
						'wcf.credits.log.moderativ',
						WCF::getUser()->username.': '.$this->text, '',
						$this->recipient);
		}
		else {
			CreditsHandler::getInstance()->transfer($this->credits,
				$this->recipient, $this->text);
		}

		$this->saved();
	}
}
