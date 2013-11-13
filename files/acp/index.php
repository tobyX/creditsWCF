<?php
/**
 * @author	Tobias Friebel
 * @copyright	2013 Tobias Friebel
 * @license	CC BY-NC-ND 3.0 http://creativecommons.org/licenses/by-nc-nd/3.0/
 * @package	com.toby.wcf.credits
 */
require_once('./global.php');
wcf\system\request\RequestHandler::getInstance()->handle('credits', true);
