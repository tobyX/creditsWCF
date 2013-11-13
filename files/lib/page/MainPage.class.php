<?php
namespace credits\page;
use wcf\page\AbstractPage;

class MainPage extends AbstractPage {
	/**
	 * @see	wcf\page\AbstractPage::$activeMenuItem
	 */
	public $activeMenuItem = 'credits.header.menu.credits';

	/**
	 * @see	wcf\page\AbstractPage::$enableTracking
	 */
	public $enableTracking = true;

	/**
	 * @see	wcf\page\AbstractPage::$neededModules
	 */
	public $neededModules = array('MODULE_CREDITS');

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
