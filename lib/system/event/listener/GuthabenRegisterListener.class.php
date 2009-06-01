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

class GuthabenRegisterListener implements EventListener
{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) 
	{
		if (!GUTHABEN_ENABLE_GLOBAL)
			return;

		if (GUTHABEN_EARN_FOR_REGISTER > 0)
			Guthaben :: add(GUTHABEN_EARN_FOR_REGISTER, 'wcf.guthaben.log.newregister');
	}
}
?>