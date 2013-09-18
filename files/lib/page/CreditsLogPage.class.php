<?php
namespace wcf\page;
use wcf\system\menu\user\UserMenu;
use wcf\system\WCF;

class CreditsLogPage extends MultipleLinkPage {
/**
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;

	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'wcf\data\creditsLog\CreditsLogList';

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = 'credits_log.time DESC';

	/**
	 * @see	wcf\page\MultipleLinkPage::readData()
	 */
	protected function initObjectList() {
		parent::initObjectList();

		$this->objectList->getConditionBuilder()->add("credits_log.userID = ?", array(WCF::getUser()->userID));
	}

	/**
	 * @see	wcf\page\Page::show()
	 */
	public function show() {
		// set active tab
		UserMenu::getInstance()->setActiveMenuItem('wcf.user.menu.community.following');

		parent::show();
	}
}
