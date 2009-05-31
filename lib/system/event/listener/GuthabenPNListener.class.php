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

require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

class GuthabenPNListener implements EventListener
{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) 
	{
		if (!GUTHABEN_ENABLE_GLOBAL)
			return;

		switch ($className)
		{
			case 'PMNewForm':
				$count = 0;
				foreach ($eventObj->recipientArray as $rec)
				{
					if ($rec['userID'] == WCF::getUser()->userID)
						$count++;
				}
				if (GUTHABEN_EARN_PER_PN > 0 && !$eventObj->draft && $count != count($eventObj->recipientArray))
					Guthaben :: add(GUTHABEN_EARN_PER_PN, 'wcf.guthaben.log.newpn', $eventObj->subject);
			break;
		}
	}
}
?>