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

class Guthaben
{

	/**
	 * get moneystring with currency
	 *
	 * @param bool float		if true, a floatvalue will be returned
	 * @param object user		a userobject
	 *
	 * @return string/float
	 */
	public static function get($float = false, User $user = null)
	{
		if ($user == null)
		{
			$user = WCF :: getUser();
		}

		if ($float) return $user->guthaben;
		return self :: format($user->guthaben);
	}

	/**
	 * check if there is enough guthaben
	 *
	 * @param float value	 	what to sub
	 * @param object user		a userobject
	 *
	 * @return bool 	false, if there is not enough guthaben, true otherwise
	 */
	public static function check($value, User $user = null)
	{
		if ($user == null)
		{
			$user = WCF :: getUser();
		}

		$value = abs(intval($value));

		if ($user->guthaben - $value < 0)
			return false;
		else
			return true;
	}

	/**
	 * format guthaben for output
	 *
	 * @param float guthaben
	 *
	 * @return string
	 */
	public static function format($guthaben)
	{
		$guthaben = round($guthaben, 2);

		// replace decimal point
		$guthaben = str_replace('.', WCF :: getLanguage()->get('wcf.global.decimalPoint'), $guthaben);

		// add thousands separator
		$guthaben = StringUtil :: addThousandsSeparator($guthaben);

		return $guthaben . ' ' . WCF :: getLanguage()->get('wcf.guthaben.currency');
	}

	/**
	 * Reset guthaben of this user
	 *
	 * @param object user		a userobject
	 *
	 * @return bool
	 */
	public static function reset(User $user)
	{
		$editor = $user->getEditor();
		$editor->updateOptions(array (
			'guthaben' => 0
		));
		
		self :: writeToLog($user->guthaben * -1, 'wcf.guthaben.log.reset', '', '', $user->userID);
		
		$user->guthaben = 0;

		return true;
	}

	/**
	 * Add guthaben to this user
	 *
	 * @param int add 			the guthaben to add
	 * @param string langvar	langvar for the log
	 * @param string text		custom usertext
	 * @param string link		url
	 * @param object user		a userobject
	 *
	 * @return bool
	 */
	public static function add($add, $langvar, $text = '', $link = '', User $user = null)
	{
		if ($user == null)
		{
			$user = WCF :: getUser();
		}

		$add = abs(intval($add));

		if ($add == 0)
			return false;

		$editor = $user->getEditor();
		$editor->updateOptions(array (
			'guthaben' => ($user->guthaben + $add)
		));

		$user->guthaben += $add;

		self :: writeToLog($add, $langvar, $text, $link, $user->userID);

		return true;
	}

	/**
	 * Sub guthaben from this user
	 *
	 * @param int 		sub 		the guthaben to sub
	 * @param string 	langvar		langvar for the log
	 * @param string 	text		custom usertext
	 * @param string 	link		url
	 * @param object 	user		a userobject
	 * @param bool		allowLess	if true, user guthaben can get less than 0
	 *
	 * @return bool
	 */
	public static function sub($sub, $langvar, $text = '', $link = '', User $user = null, $allowLess = false)
	{
		if ($user == null)
		{
			$user = WCF :: getUser();
		}

		$sub = abs(intval($sub));

		if ($sub == 0 || (!$allowLess && !self :: check($sub, $user)))
			return false;

		$editor = $user->getEditor();
		$editor->updateOptions(array (
									'guthaben' => ($user->guthaben - $sub),
									)
							   );

		$user->guthaben -= $sub;

		self :: writeToLog(($sub * -1), $langvar, $text, $link, $user->userID);

		return true;
	}

	/**
	 * write to guthaben to log
	 *
	 * @param float $guthaben
	 * @param string $langvar
	 * @param string $text
	 * @param string $link
	 * @param int $userID
	 */
	public static function writeToLog($guthaben, $langvar, $text, $link, $userID)
	{
		$sql = "INSERT INTO wcf" . WCF_N . "_guthaben_log
			    SET guthaben = " . $guthaben . ",
			    langvar = '" . escapeString($langvar) . "',
			    text = '" . escapeString($text) . "',
			    link = '" . escapeString($link) . "',
			    userID = " . $userID . ",
			    time = " . TIME_NOW;

		WCF :: getDB()->sendQuery($sql);
	}

	/**
	 * transfer guthaben
	 *
	 * @param int trans 		the guthaben to transfer
	 * @param int userID		the user to transfer the guthaben to
	 * @param string text		text for the log
	 * @param object user		a userobject
	 *
	 * @return bool
	 */
	public static function transfer($trans, $userID, $text = '', User $user = null)
	{
		if ($user == null)
		{
			$user = WCF :: getUser();
		}

		$totrans = new User($userID);

		if ($totrans->userID != $userID || $userID == $user->userID)
			return false;

		if (empty($text))
			$text = '---';

		if (!self :: sub($trans, 'wcf.guthaben.log.transferto', ' ' . $totrans->username . ': ' . $text, '', $user))
			return false;

		self :: add($trans, 'wcf.guthaben.log.transferfrom', ' ' . $user->username . ': ' . $text, '', $totrans);

		return true;
	}

	/**
	 * compress log
	 *
	 * @param object user		a userobject
	 */
	public static function compressLog(User $user = null)
	{
		if ($user == null)
		{
			$user = WCF :: getUser();
		}

		$sql = "DELETE FROM wcf" . WCF_N . "_guthaben_log
				WHERE userID = " . $user->userID;
		WCF :: getDB()->sendQuery($sql);

		self :: writeToLog(floatval($user->guthaben), 'wcf.guthaben.log.compress', '', '', $user->userID);
	}

	/**
	 * take daily tax and remove it from user
	 *
	 * @param object user		a userobject
	 */
	public static function dailyTax(User $user)
	{
		if (GUTHABEN_TAX_PER_DAY == 0)
			return;

		$tax = $user->guthaben * GUTHABEN_TAX_PER_DAY / 100;
		$tax = floor($tax);

		self :: sub($tax, 'wcf.guthaben.log.dailytax', '', '', $user);
	}
}
?>