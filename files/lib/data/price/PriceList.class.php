<?php
namespace credits\data\price;
use wcf\data\DatabaseObjectList;

/**
 * Represents a list of credits prices.
 *
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
class PriceList extends DatabaseObjectList {
	/**
	 * @see	wcf\data\DatabaseObjectList::$className
	 */
	public $className = 'credits\data\price\Price';
}
