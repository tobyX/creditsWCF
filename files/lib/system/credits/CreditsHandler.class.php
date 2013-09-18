<?php
namespace wcf\system\credits;
use wcf\system\SingletonFactory;
use wcf\data\user\User;
use wcf\system\WCF;
use wcf\data\creditsLog\CreditsLogAction;
use wcf\data\user\UserAction;
use wcf\util\CreditsUtil;

/**
 * Handle all credits actions
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CreditsHandler extends SingletonFactory {

	/**
	 * Add credits to this user
	 *
	 * @param float  $credits 	the credits to add
	 * @param string langvar	langvar for the log
	 * @param string text		custom usertext
	 * @param string link		url
	 * @param object user		a userobject
	 *
	 * @return bool
	 */
	public function add($credits, $langvar, $text = '', $link = '', User $user = null) {
		if ($user == null)
			$user = WCF::getUser();

		$add = abs(floatval($credits));

		if ($add == 0)
			return false;

		$objectAction = new UserAction(array($user->userID), 'update', array(
			'options' => array(
				User::getUserOptionID('credits') => ($user->credits + $credits)
			)
		));
		$objectAction->executeAction();

		$user->credits += $credits;

		$data = array(
			'userID' => $user->userID,
			'langvar' => $langvar,
			'text' => $text,
			'link' => $link,
			'credits' => $credits,
			'time' => TIME_NOW
		);

		$objectAction = new CreditsLogAction(array(), 'create',
				array('data' => $data));
		$objectAction->executeAction();

		return true;
	}

	/**
	 * Sub guthaben from this user
	 *
	 * @param float 	$credits 	the credits to subtract, can be negativ
	 * @param string 	langvar		langvar for the log
	 * @param string 	text		custom usertext
	 * @param string 	link		url
	 * @param object 	user		a userobject
	 *
	 * @return bool
	 */
	public function subtract($credits, $langvar, $text = '', $link = '', User $user = null) {
		if ($user == null)
			$user = WCF::getUser();

		$credits = abs(floatval($credits));

		if ($credits == 0 || (!CREDITS_ALLOW_NEGATIV &&
				!$this->check($credits, $user)))
			return false;

		$objectAction = new UserAction(array($user->userID), 'update', array(
			'options' => array(
				User::getUserOptionID('credits') => ($user->credits - $credits)
			)
		));
		$objectAction->executeAction();

		$user->credits -= $credits;

		$data = array(
			'userID' => $user->userID,
			'langvar' => $langvar,
			'text' => $text,
			'link' => $link,
			'credits' => $credits,
			'time' => TIME_NOW
		);

		$objectAction = new CreditsLogAction(array(), 'create',
				array('data' => $data));
		$objectAction->executeAction();


		return true;
	}

	/**
	 * get credits formatted (with currency)
	 *
	 * @param object user		a userobject
	 *
	 * @return string
	 */
	public function get(User $user = null) {
		if ($user == null)
			$user = WCF::getUser();

		return CreditsUtil::format($user->credits);
	}

	/**
	 * check if there are enough credits
	 *
	 * @param float credits	 	the amount to check
	 * @param object user		a userobject
	 *
	 * @return bool 	false, if there are not enough credits, true otherwise
	 */
	public function check($credits, User $user = null) {
		if ($user == null)
			$user = WCF::getUser();

		$credits = abs(floatval($credits));

		if ($user->credits - $credits < 0)
			return false;
		else
			return true;
	}

	/**
	 * Reset credits of this user
	 *
	 * @param object user		a userobject
	 *
	 * @return bool
	 */
	public function reset(User $user) {
		$objectAction = new UserAction(array($user->userID), 'update', array(
			'options' => array(
				User::getUserOptionID('credits') => 0.0
			)
		));
		$objectAction->executeAction();

		$data = array(
				'userID' => $user->userID,
				'langvar' => 'wcf.credits.log.reset',
				'text' => '',
				'link' => '',
				'credits' => $user->credits * -1,
				'time' => TIME_NOW
		);

		$objectAction = new CreditsLogAction(array(), 'create',
				array('data' => $data));
		$objectAction->executeAction();

		$user->credits = 0;

		return true;
	}

	/**
	 * transfer credits to another user
	 *
	 * @param float 	$credits 		the credits to transfer
	 * @param int 		$recipient		the user to transfer the credits to
	 * @param string text		text for the log
	 * @param object user		a userobject
	 *
	 * @return bool
	 */
	public function transfer($credits, User $recipient, $text = '',
			User $user = null) {
		if ($user == null)
			$user = WCF::getUser();

		if ($recipient->userID == $user->userID)
			return false;

		if (empty($text))
			$text = '---';

		if (!$this->subtract($credits, 'wcf.credits.log.transferto', ' ' . $totrans->username . ': ' . $text, '', $user))
			return false;

		$this->add($credits, 'wcf.credits.log.transferfrom', ' ' . $user->username . ': ' . $text, '', $recipient);

		return true;
	}

	/**
	 * take daily tax and subtract it from user
	 *
	 * @param object user		a userobject
	 */
	public function dailyTax(User $user) {
		if (CREDITS_TAX_PER_DAY == 0)
			return;

		$tax = $user->credits * CREDITS_TAX_PER_DAY / 100;
		$tax = round($tax, 2);

		if ($tax < 0)
			return;

		$this->subtract($tax, 'wcf.credits.log.dailytax', '', '', $user);
	}
}
