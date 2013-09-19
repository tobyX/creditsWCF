<?php
namespace wcf\page;

class CreditsMainPage extends AbstractPage {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'wcf.header.menu.credits';

	/**
	 * @see	wcf\page\AbstractPage::$enableTracking
	 */
	public $enableTracking = true;

	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_CREDITS');

	/**
	 * list of the latest entries
	 * @var	blog\data\entry\ViewableEntryList
	 */
	public $entryList = null;

	/**
	 * @see	wcf\page\IPage::readData()
	 */
	public function readData() {
		parent::readData();


	}

	/**
	 * @see	wcf\page\IPage::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();


	}
}
