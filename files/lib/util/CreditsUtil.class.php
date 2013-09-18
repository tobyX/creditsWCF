<?php
namespace wcf\util;
use wcf\system\WCF;

/**
 * Contains Credits-related functions.
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
final class CreditsUtil {
	/**
	 * format credits for output
	 *
	 * @param float $credits
	 *
	 * @return string
	 */
	public static function format($credits) {
		$credits = StringUtil::formatDouble($credits, 2);

		return self::appendCurrency($credits);
	}

	/**
	 * append currency for output
	 *
	 * @param string $credits
	 *
	 * @return string
	 */
	public static function addCurrency($credits) {
		return WCF::getLanguage()->getDynamicVariable('wcf.credits.currency', array('credits' => $credits));
	}
}
