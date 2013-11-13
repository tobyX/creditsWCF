<?php

class GuthabenPricesPage extends AbstractPage
{
	/**
	 * Name of the template for the called page.
	 */
	public $templateName = 'guthabenPrices';

	/**
	 * an array to display in the guthaben section
	 */
	private $prices = array ();

	/**
	 * Loads cached menu items.
	 */
	protected function loadCache ()
	{
		// call loadCache event
		EventHandler :: fireAction($this, 'loadCache');

		WCF :: getCache()->addResource('guthabenPrices-' . PACKAGE_ID, WCF_DIR . 'cache/cache.guthabenPrices-' . PACKAGE_ID . '.php', WCF_DIR . 'lib/system/cache/CacheBuilderGuthabenPrices.class.php');
		$this->prices = WCF :: getCache()->get('guthabenPrices-' . PACKAGE_ID);
	}

	/**
	 * @see Page::readData()
	 */
	public function readData()
	{
		parent :: readData();

		$this->loadCache();

		foreach ($this->prices as $id => $price)
		{
			$this->prices[$id]['priceConstant'] = constant($price['priceConstant']);

			if ($this->prices[$id]['priceConstant'] == 0)
			{
				unset($this->prices[$id]);
				continue;
			}

			if ($price['priceCurrency'] == '')
				$this->prices[$id]['price'] = Guthaben :: format($this->prices[$id]['priceConstant']);
			else
				$this->prices[$id]['price'] = StringUtil::formatNumeric($this->prices[$id]['priceConstant']) . ' ' . $price['priceCurrency'];
		}
	}

	/**
	 * @see Page::assignVariables()
	 */
	public function assignVariables()
	{
		parent :: assignVariables();

		WCF :: getTPL()->assign('prices', $this->prices);
	}

	/**
	 * @see Page::show()
	 */
	public function show()
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
