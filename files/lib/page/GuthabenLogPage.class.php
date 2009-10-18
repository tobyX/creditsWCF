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

require_once (WCF_DIR . 'lib/page/MultipleLinkPage.class.php');
require_once (WCF_DIR . 'lib/page/util/menu/PageMenu.class.php');

class GuthabenLogPage extends MultipleLinkPage
{
	public $templateName = 'guthabenLog';
	public $result = array ();
	public $logEntries = array ();
	private $pageSum = 0;
	public $itemsPerPage = 20;
	public $pageNo = 1;

	/**
	 * @see Page::readParameters()
	 */
	public function readParameters()
	{
		parent :: readParameters();

		// check permission
		if (!WCF :: getUser()->getPermission('guthaben.canuse') || !WCF :: getUser()->getPermission('guthaben.log.canuse'))
		{
			require_once (WCF_DIR . 'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}

		if ($this->action == 'compress')
		{
			Guthaben :: compressLog();
		}

		$this->getLog();
	}

	/**
	 * @see Page::readData()
	 */
	public function readData()
	{
		parent :: readData();
		// get messages
		$this->logEntries = $this->readLog();
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();

		WCF :: getTPL()->assign(array (
			'logEntries' => $this->logEntries,
			'pageSum' => $this->pageSum,
			'allSum' => Guthaben :: get(),
		));
	}

	/**
	 * @see MultipleLinkPage::countItems()
	 */
	public function countItems()
	{
		parent :: countItems();

		$sql = "SELECT 	COUNT(*) AS count
				FROM	wcf" . WCF_N . "_guthaben_log
				WHERE	userID = " . WCF :: getUser()->userID . "
				ORDER BY logID";

		$result = WCF :: getDB()->getFirstRow($sql);
		return $result['count'];
	}

	/**
	 * Gets the data from database.
	 */
	protected function getLog()
	{
		$sql = "SELECT 	*
				FROM	wcf" . WCF_N . "_guthaben_log
				WHERE	userID = " . WCF :: getUser()->userID . "
				ORDER BY logID";

		$sql .= " LIMIT " . $this->itemsPerPage . " OFFSET " . ($this->pageNo - 1) * $this->itemsPerPage;

		$this->result = WCF :: getDB()->getResultList($sql);
	}

	/**
	 * Gets the data of the log.
	 */
	protected function readLog()
	{
		$messages = array ();
		$count = count($this->result);
		for ($i = 0; $i < $count; $i++)
		{
			$this->pageSum += $this->result[$i]['guthaben'];
			$this->result[$i]['guthaben'] = Guthaben :: format($this->result[$i]['guthaben']);
			$messages[] = $this->result[$i];
		}

		$this->pageSum = Guthaben :: format($this->pageSum);

		return $messages;
	}

	/**
	 * @see Page::show()
	 */
	public function show()
	{
		// check permission
		if (!WCF :: getUser()->getPermission('guthaben.canuse') || !WCF :: getUser()->getPermission('guthaben.log.canuse'))
		{
			require_once (WCF_DIR . 'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}

		// set active header menu item
		PageMenu :: setActiveMenuItem('wcf.header.menu.guthabenmain');

		parent :: show();
	}
}
?>
