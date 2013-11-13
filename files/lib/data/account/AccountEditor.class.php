<?php
namespace credits\data\account;
use wcf\data\DatabaseObjectEditor;

/**
 * Extends the creditsaccount object with functions to create, update and delete accounts entries.
 *
 * @author		Tobias Friebel
 * @copyright		2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class AccountEditor extends DatabaseObjectEditor {
	/**
	 * @see	wcf\data\DatabaseObjectEditor::$baseClass
	 */
	protected static $baseClass = 'credits\data\account\CreditsAccount';
}
