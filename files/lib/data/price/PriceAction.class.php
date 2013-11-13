<?php
namespace credits\data\price;
use wcf\data\AbstractDatabaseObjectAction;

/**
 * Executes creditsprice related actions.
 *
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
class PriceAction extends AbstractDatabaseObjectAction {
	/**
	 * @see	wcf\data\AbstractDatabaseObjectAction::$className
	 */
	protected $className = 'credits\data\price\PriceEditor';
}
