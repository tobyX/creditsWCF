<?php
namespace credits\page;
use wcf\system\menu\user\UserMenu;
use wcf\system\WCF;
use wcf\page\MultipleLinkPage;

class StatementPage extends MultipleLinkPage {
/**
	 * @see	wcf\page\AbstractPage::$loginRequired
	 */
	public $loginRequired = true;

	/**
	 * @see	wcf\page\MultipleLinkPage::$objectListClassName
	 */
	public $objectListClassName = 'credits\data\statement\StatementList';

	/**
	 * @see	wcf\data\DatabaseObjectList::$sqlOrderBy
	 */
	public $sqlOrderBy = 'statement.time DESC';

	/**
	 * @see	wcf\page\MultipleLinkPage::readData()
	 */
	protected function initObjectList() {
		parent::initObjectList();

		$this->objectList->getConditionBuilder()->add("statement.userID = ?", array(WCF::getUser()->userID));
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
