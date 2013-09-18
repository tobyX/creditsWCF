DROP TABLE IF EXISTS wcf1_credits_log;
CREATE TABLE wcf1_credits_log
(
	logID INT(10) unsigned NOT NULL auto_increment,
	userID INT(10) unsigned NOT NULL DEFAULT 0,
	langvar VARCHAR(100) NOT NULL DEFAULT '',
	text VARCHAR(255) NOT NULL DEFAULT '',
	link VARCHAR(100) NOT NULL DEFAULT '',
	credits FLOAT(11) NOT NULL DEFAULT 0,
	time INT(10) unsigned NOT NULL DEFAULT 0,
	deleted TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (logID),
	KEY userID (userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wcf1_credits_mainpage;
CREATE TABLE wcf1_credits_mainpage
(
	menuItemID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	packageID INT(10) UNSIGNED NOT NULL,
	menuItem VARCHAR(255) NOT NULL DEFAULT '',
	parentMenuItem VARCHAR(255) NOT NULL DEFAULT '',
	menuItemLink VARCHAR(255) NOT NULL DEFAULT '',
	menuItemDescription TEXT NOT NULL,
	menuItemIcon VARCHAR(255) NOT NULL DEFAULT '',
	showOrder INT(10) NOT NULL default '0',
  	permissions TEXT,
	PRIMARY KEY ( menuItemID ),
	UNIQUE KEY packageID (packageID, menuItem)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS wcf1_credits_prices;
CREATE TABLE wcf1_credits_prices
(
	priceItemID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	packageID INT(10) UNSIGNED NOT NULL,
	priceItem VARCHAR(255) NOT NULL DEFAULT '',
	priceDescription VARCHAR(255) NOT NULL DEFAULT '',
	priceConstant VARCHAR(255) NOT NULL DEFAULT '',
	priceIsNegative TINYINT(1) NOT NULL DEFAULT 0,
	priceCurrency VARCHAR(100) NOT NULL DEFAULT '',
	PRIMARY KEY ( priceItemID ),
	UNIQUE KEY packageID (packageID, priceItem)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;