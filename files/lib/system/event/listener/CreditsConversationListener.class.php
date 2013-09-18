<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\WCF;
use wcf\system\credits\CreditsHandler;

/**
 * listen for start of new conversations and give credits to starter
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class CreditsConversationListener implements IEventListener{
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_CREDITS)
			return;

		$count = 0;
		foreach ($eventObj->participantIDs as $participantID) {
			if ($participantID == WCF::getUser()->userID)
				$count++;
		}

		if (CREDITS_EARN_PER_PN > 0 && !$eventObj->draft && $count != count($eventObj->participantIDs))
			CreditsHandler::getInstance()->add(CREDITS_EARN_PER_PN, 'wcf.credits.log.newpn', $eventObj->subject);
	}
}
