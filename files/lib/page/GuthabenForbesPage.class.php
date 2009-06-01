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
}
?>