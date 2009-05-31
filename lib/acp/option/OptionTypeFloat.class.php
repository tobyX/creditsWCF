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

require_once (WCF_DIR . 'lib/acp/option/OptionTypeText.class.php');

class OptionTypeFloat extends OptionTypeText
{
	/**
	 * @see OptionType::getData()
	 */
	public function getData($optionData, $newValue)
	{
		$newValue = str_replace(',', '.', $newValue);
		return floatval($newValue);
	}
}
?>