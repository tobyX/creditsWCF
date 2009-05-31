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

require_once(WCF_DIR.'lib/data/cronjobs/Cronjob.class.php');

class GuthabenCronjob implements Cronjob 
{
	/**
	 * @see Cronjob::execute()
	 */
	public function execute($data) 
	{
		if (!GUTHABEN_ENABLE_GLOBAL || (!GUTHABEN_TAX_PER_DAY && !GUTHABEN_ENABLE_AUTOCOMPRESS))
			return;
		
		if (file_exists(WCF_DIR.'cache/guthabenCronJobLock') && file_get_contents (WCF_DIR.'cache/guthabenCronJobLock') == date('Y-m-d'))
			return;
		
		file_put_contents (WCF_DIR.'cache/guthabenCronJobLock', date('Y-m-d'), LOCK_EX);
		
		// get user ids
		$sql = "SELECT	userID
				FROM	wcf".WCF_N."_user
				WHERE	banned = 0 AND lastActivityTime > ".(TIME_NOW - 8640000);
		$result = WCF::getDB()->sendQuery($sql);
		
		while ($row = WCF::getDB()->fetchArray($result)) 
		{
			$user = new User($row['userID']);
			
			if (GUTHABEN_TAX_PER_DAY)
				Guthaben :: dailyTax($user);
			
			if (GUTHABEN_ENABLE_AUTOCOMPRESS && date('d', TIME_NOW) == '15')
				Guthaben :: compressLog($user);
		}
	}
}
?>