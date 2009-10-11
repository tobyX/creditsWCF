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

require_once (WCF_DIR . 'lib/page/MembersListPage.class.php');

class GuthabenForbesPage extends MembersListPage
{
	/**
	 * @see Page::readParameters()
	 */
	public function readParameters()
	{
		parent :: readParameters();

		// check permission
		if (!WCF :: getUser()->getPermission('guthaben.canuse') || !WCF :: getUser()->getPermission('guthaben.forbes.canuse'))
		{
			require_once (WCF_DIR . 'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}
		
		if (!in_array('guthaben', $this->activeFields))
			$this->activeFields[] = 'guthaben';
			
		$this->defaultSortField = 'guthaben';
		$this->defaultSortOrder = 'DESC';
	}
	
	/**
	 * @see Page::show()
	 * do everything the parent classes do, but exchange MembersList with GuthabenForbes in template
	 */
	public function show() 
	{
		// set active header menu item
		PageMenu::setActiveMenuItem('wcf.header.menu.memberslist');
		
		// check permission
		WCF::getUser()->checkPermission('user.membersList.canView');
		
		if (MODULE_MEMBERS_LIST != 1) 
		{
			throw new IllegalLinkException();
		}
		
		// check permission
		if (!empty($this->neededPermissions)) WCF::getUser()->checkPermission($this->neededPermissions);
		
		// read data
		$this->readData();

		// assign variables
		$this->assignVariables();		
		
		// call show event
		EventHandler::fireAction($this, 'show');
		
		// show template
		if (!empty($this->templateName)) 
		{
			$output = WCF::getTPL()->fetch($this->templateName);
			
			$output = str_replace('MembersList', 'GuthabenForbes', $output);
			
			echo $output;
		}
	}
}
?>