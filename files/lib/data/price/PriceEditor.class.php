<?php
namespace credits\data\price;
use wcf\data\DatabaseObjectEditor;
use wcf\system\WCF;

/**
 * Extends the creditsprice object with functions to create, update and delete prices.
 *
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
class PriceEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectEditor::$baseClass
	 */
	protected static $baseClass = 'credits\data\price\Price';
}
