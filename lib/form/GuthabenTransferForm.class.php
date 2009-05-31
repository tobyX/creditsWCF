<?php
/*
 * +-----------------------------------------+
 * | Copyright (c) 2008 Tobias Friebel       |
 * +-----------------------------------------+
 * | Authors: Tobias Friebel <TobyF@Web.de>	 |
 * +-----------------------------------------+
 *
 * CC Namensnennung-Keine kommerzielle Nutzung-Keine Bearbeitung
 * http://creativecommons.org/licenses/by-nc-nd/2.0/de/
 *
 * $Id$
 */

require_once (WCF_DIR . 'lib/form/AbstractForm.class.php');
require_once (WCF_DIR . 'lib/data/user/UserProfile.class.php');
require_once (WCF_DIR . 'lib/page/util/menu/HeaderMenu.class.php');

class GuthabenTransferForm extends AbstractForm
{
	public $templateName = 'guthabenTransfer';
	private $userID = 0;
	private $transfer = 0;
	private $text = '';
	private $recipient = '';
	private $moderativ = false;

	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters()
	{
		parent :: readFormParameters();

		if (isset ($_POST['recipient']))
			$this->recipient = StringUtil :: trim($_POST['recipient']);

		if (isset ($_POST['transfer']))
			$this->transfer = abs(intval($_POST['transfer']));

		if (isset ($_POST['text']))
			$this->text = StringUtil :: trim($_POST['text']);

		if (isset ($_POST['moderativ']))
			$this->moderativ = (bool) $_POST['moderativ'];
	}

	/**
	 * @see Form::validate()
	 */
	public function validate()
	{
		parent :: validate();

		if (!empty ($this->recipient))
		{
			$this->userID = $this->validateRecipient($this->recipient);
		}
		else
		{
			throw new UserInputException('recipient', 'empty');
		}

		if (!WCF::getUser()->getPermission('guthaben.moderation.cantransfer'))
		{
			$this->moderativ = false;
		}

		if ($this->transfer == 0)
		{
			throw new UserInputException('transfer', 'empty');
		}

		if (Guthaben :: get(true) < $this->transfer && !$this->moderativ)
		{
			throw new UserInputException('transfer', 'tomutch');
		}
	}

	/**
	 * Checks the given recipients.
	 */
	protected function validateRecipient($recipient)
	{
		// get recipient's profile
		$user = new UserProfile(null, null, $recipient);
		if (!$user->userID)
		{
			throw new UserInputException('recipient', array('type' => 'notFound', 'username' => $recipient));
		}

		// active user is ignored by recipient
		if ($user->ignoredUser)
		{
			throw new UserInputException('recipient', array('type' => 'ignoresYou', 'username' => $recipient));
		}

		if (!$user->getPermission('guthaben.transfer.canreceive') || !$user->getPermission('guthaben.canuse'))
		{
			throw new UserInputException('recipient', array('type' => 'cannotReceive', 'username' => $recipient));
		}

		return $user->userID;
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
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
	public function save()
	{
		parent :: save();

		// check permission
		if (!WCF :: getUser()->getPermission('guthaben.canuse') || !WCF::getUser()->getPermission('guthaben.transfer.canuse'))
		{
			require_once (WCF_DIR . 'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}

		if ($this->moderativ)
		{
			$user = new User($this->userID);

			if (intval($_POST['transfer']) < 0)
				Guthaben :: sub($this->transfer, 'wcf.guthaben.log.moderativ', WCF::getUser()->username.': '.$this->text, '', $user);
			else
				Guthaben :: add($this->transfer, 'wcf.guthaben.log.moderativ', WCF::getUser()->username.': '.$this->text, '', $user);
		}
		else
			Guthaben :: transfer($this->transfer, $this->userID, $this->text);

		$this->saved();

		header('Location: '.FileUtil::addTrailingSlash(dirname(WCF::getSession()->requestURI)).'index.php?page=guthabenLog' . SID_ARG_2ND_NOT_ENCODED);
		exit;
	}

	/**
	 * @see Page::show()
	 */
	public function show()
	{
		if (!WCF::getUser()->userID || !WCF::getUser()->getPermission('guthaben.canuse') || !WCF::getUser()->getPermission('guthaben.transfer.canuse'))
		{
			require_once(WCF_DIR.'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}

		// set active header menu item
		HeaderMenu::setActiveMenuItem('wcf.header.menu.guthabenmain');

		parent::show();
	}
}
?>
