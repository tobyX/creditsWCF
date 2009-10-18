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

require_once (WCF_DIR . 'lib/page/AbstractPage.class.php');
require_once (WCF_DIR . 'lib/page/util/menu/PageMenu.class.php');

class GuthabenMainPage extends AbstractPage
{
	public $menuItems = null;
	public $templateName = 'guthabenMain';

	/**
	 * Loads cached menu items.
	 */
	protected function loadCache ()
	{
		// call loadCache event
		EventHandler :: fireAction($this, 'loadCache');

		WCF :: getCache()->addResource('guthabenMainPage-' . PACKAGE_ID, WCF_DIR . 'cache/cache.guthabenMainPage-' . PACKAGE_ID . '.php', WCF_DIR . 'lib/system/cache/CacheBuilderGuthabenMainpage.class.php');
		$this->menuItems = WCF :: getCache()->get('guthabenMainPage-' . PACKAGE_ID);
	}

	/**
	 * Checks the permissions of the menu items.
	 * Removes items without permission.
	 */
	protected function checkPermissions ()
	{
		foreach ($this->menuItems['items'][$this->action] as $key => $item)
		{
			$hasPermission = true;
			// check the permission of this item for the active user
			if (!empty($item['permissions']))
			{
				$hasPermission = false;
				$permissions = explode(',', $item['permissions']);
				foreach ($permissions as $permission)
				{
					if (WCF :: getUser()->getPermission($permission))
					{
						$hasPermission = true;
						break;
					}
				}
			}

			if (!$hasPermission)
			{
				// remove this item
				unset($this->menuItems['items'][$this->action][$key]);
			}
		}
	}

	/**
	 * @see Page::readData()
	 */
	public function readData()
	{
		parent :: readData();

		$this->loadCache();

		if (empty($this->action))
		{
			$this->action = 'mainPage';
		}

		$this->checkPermissions();
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables ()
	{
		parent :: assignVariables();

		WCF :: getTPL()->assign('parentItems', $this->menuItems['parents']);
		WCF :: getTPL()->assign('childItems', $this->menuItems['items'][$this->action]);
		WCF :: getTPL()->assign('activeParent', $this->action);
	}

	/**
	 * @see Page::show()
	 */
	public function show ()
	{
		if (!WCF :: getUser()->userID || !WCF :: getUser()->getPermission('guthaben.canuse'))
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