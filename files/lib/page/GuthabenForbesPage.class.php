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

require_once (WCF_DIR . 'lib/page/SortablePage.class.php');
require_once (WCF_DIR . 'lib/data/user/UserProfile.class.php');
require_once (WCF_DIR . 'lib/data/user/option/UserOptions.class.php');
require_once (WCF_DIR . 'lib/page/util/menu/PageMenu.class.php');

class GuthabenForbesPage extends SortablePage
{
	public $templateName = 'guthabenForbes';

	public $defaultSortField = 'guthaben';
	public $defaultSortOrder = 'DESC';
	
	public $defaultSortFields = array (
		'username', 
		'guthaben', 
	);

	public $userOptions;
	public $members = array ();
	
	public $allGuthaben = 0;
	public $durchschnittGuthaben = 0;
	public $oberschichtGuthaben = 0;

	/**
	 * @see Page::readParameters()
	 */
	public function readParameters()
	{
		parent :: readParameters();
		
		// get user options
		$this->userOptions = new UserOptions('medium');
	}

	/**
	 * @see SortablePage::validateSortField()
	 */
	public function validateSortField()
	{
		parent :: validateSortField();
		
		switch ($this->sortField)
		{
			case 'username':
			break;
			
			default:
				$this->sortField = 'guthaben';
		}
	}

	/**
	 * @see Page::readData()
	 */
	public function readData()
	{
		parent :: readData();
		
		$this->readMembers();
		$this->getStatistics();
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();
		
		// show page
		WCF :: getTPL()->assign(array (
			'members' => $this->members,
			'items' => $this->items,
			'allGuthaben' => Guthaben :: format($this->allGuthaben),
			'durchschnittGuthaben' => Guthaben :: format($this->durchschnittGuthaben),
			'oberschichtGuthaben' => StringUtil :: formatNumeric($this->oberschichtGuthaben)
		));
	}

	/**
	 * @see Page::show()
	 */
	public function show()
	{
		// set active header menu item
		PageMenu :: setActiveMenuItem('wcf.header.menu.guthabenmain');
		
		// check permission
		WCF :: getUser()->checkPermission('guthaben.forbes.canuse');
		WCF :: getUser()->checkPermission('guthaben.canuse');
		
		parent :: show();
	}

	/**
	 * Returns the data of a member.
	 * 
	 * @param	array		$row
	 * @return	array 
	 */
	protected function getMember($row)
	{
		$user = new UserProfile(null, $row);
		$username = StringUtil :: encodeHTML($row['username']);
		
		$protectedProfile = ($user->protectedProfile && WCF :: getUser()->userID != $user->userID);
		
		$userData = array (
			'user' => $user, 
			'encodedUsername' => $username, 
			'protectedProfile' => $protectedProfile
		);
		
		foreach (array('username', 'guthaben') as $field)
		{
			switch ($field)
			{
				// default fields
				case 'username':
					$userData['username'] = '<div class="containerIconSmall">';
					if ($user->isOnline())
					{
						$title = WCF :: getLanguage()->get('wcf.user.online', array (
							'$username' => $username
						));
						$userData['username'] .= '<img src="' . StyleManager :: getStyle()->getIconPath('onlineS.png') . '" alt="' . $title . '" title="' . $title . '" />';
					}
					else
					{
						$title = WCF :: getLanguage()->get('wcf.user.offline', array (
							'$username' => $username
						));
						$userData['username'] .= '<img src="' . StyleManager :: getStyle()->getIconPath('offlineS.png') . '" alt="' . $title . '" title="' . $title . '" />';
					}
					
					$userData['username'] .= '</div><div class="containerContentSmall">';
					$title = WCF :: getLanguage()->get('wcf.user.viewProfile', array (
						'$username' => $username
					));
					$userData['username'] .= '<p><a href="index.php?page=User&amp;userID=' . $row['userID'] . SID_ARG_2ND . '" title="' . $title . '">' . $username . '</a></p>';
					
					if (MODULE_USER_RANK == 1 && $user->getUserTitle())
					{
						$userData['username'] .= '<p class="smallFont">' . $user->getUserTitle() . ' ' . ($user->getRank() ? $user->getRank()->getImage() : '') . '</p>';
					}
					
					$userData['username'] .= '</div>';
				
				break;
				
				// user options	
				default:
					$userData[$field] = '';
					$option = $this->userOptions->getOptionValue($field, $user);
					if (!$protectedProfile && $option)
					{
						$userData[$field] = $option['optionValue'];
					}
			}
		}
		
		return $userData;
	}

	/**
	 * Counts the number of users.
	 * 
	 * @return	integer
	 */
	public function countItems()
	{
		parent :: countItems();
		
		// count members
		$sql = "SELECT	COUNT(*) AS count
				FROM	wcf" . WCF_N . "_user";
		
		$row = WCF :: getDB()->getFirstRow($sql);
		
		return $row['count'];
	}

	/**
	 * Gets the list of members for the current page number.
	 */
	protected function readMembers()
	{
		if ($this->items)
		{
			$sql = "SELECT		user.*, user_option.*
					FROM		wcf" . WCF_N . "_user user
					LEFT JOIN 	wcf" . WCF_N . "_user_option_value user_option
						ON 		(user_option.userID = user.userID) 
					ORDER BY	" . ($this->sortField == 'guthaben' ? 'userOption' . User :: getUserOptionID('guthaben') : $this->sortField ) . " " . $this->sortOrder;
				
			$result = WCF :: getDB()->sendQuery($sql, $this->itemsPerPage, ($this->pageNo - 1) * $this->itemsPerPage);
			
			while ($row = WCF :: getDB()->fetchArray($result))
			{
				if (empty($row['username']))
					continue;
					
				$this->members[] = $this->getMember($row);
			}
		}
	}
	
	/**
	 * Get some small statistics
	 */
	protected function getStatistics()
	{
	 	if ($this->items)
		{
			$optionID = User :: getUserOptionID('guthaben');
			
			$sql = "SELECT 	SUM(userOption" . $optionID . ") AS alles
					FROM	wcf" . WCF_N . "_user_option_value";
			
			$row = WCF :: getDB()->getFirstRow($sql);
		
			$this->allGuthaben = $row['alles'];
			$this->durchschnittGuthaben = $this->allGuthaben / $this->items;
			
			$sql = "SELECT SUM(userOption" . $optionID . ") AS reichste 
					FROM (
						SELECT 		userOption" . $optionID . "
						FROM		wcf" . WCF_N . "_user_option_value
						ORDER BY	userOption" . $optionID . " DESC 
						LIMIT " . round($this->items * 0.1, 0) . "
					) AS hack";
			
			$row = WCF :: getDB()->getFirstRow($sql);
			
			$this->oberschichtGuthaben = $row['reichste'] / ($this->allGuthaben / 100);
		}
	}
}
?>