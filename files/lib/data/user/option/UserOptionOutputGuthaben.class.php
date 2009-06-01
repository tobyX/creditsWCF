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

require_once (WCF_DIR . 'lib/data/user/option/UserOptionOutput.class.php');
require_once (WCF_DIR . 'lib/data/user/User.class.php');

class UserOptionOutputGuthaben implements UserOptionOutput
{
	/**
	 * @see UserOptionOutput::getShortOutput()
	 */
	public function getShortOutput(User $user, $optionData, $value)
	{
		return $this->getOutput($user, $optionData, $value);
	}

	/**
	 * @see UserOptionOutput::getMediumOutput()
	 */
	public function getMediumOutput(User $user, $optionData, $value)
	{
		return $this->getOutput($user, $optionData, $value);
	}

	/**
	 * @see UserOptionOutput::getOutput()
	 */
	public function getOutput(User $user, $optionData, $value)
	{
		if (empty($value) || $value == '0')
			$value = '0.00';

		return Guthaben :: format($value);
	}
}
?>
