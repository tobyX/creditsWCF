<?php
namespace wcf\system\event\listener;
use wcf\system\event\IEventListener;
use wcf\system\credits\CreditsHandler;

/**
 * listen for activation of new users and give them credits
 *
 * @author		Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license		CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package		com.toby.wcf.credits
 */
class RegistrationActivationListener implements IEventListener {

	/**
	 * @see	wcf\system\event\IEventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (!MODULE_CREDITS)
			return;

		if (CREDITS_EARN_FOR_REGISTER > 0)
			CreditsHandler::getInstance()->add(CREDITS_EARN_FOR_REGISTER,
					'wcf.credits.log.newregister', '', '', $eventObj->user);
	}
}
