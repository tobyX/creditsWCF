CREATE TABLE wcf1_guthaben_log
(
	logID int(10) unsigned NOT NULL auto_increment,
	userID int(10) unsigned NOT NULL DEFAULT 0,
	langvar varchar(100) NOT NULL DEFAULT '',
	text varchar(255) NOT NULL DEFAULT '',
	link varchar(100) NOT NULL DEFAULT '',
	guthaben int(11) NOT NULL DEFAULT 0,
	time int(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (logID),
	KEY userID (userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE wcf1_guthaben_mainpage
(
	menuItemID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
	packageID INT(10) UNSIGNED NOT NULL,
	menuItem VARCHAR(255) NOT NULL DEFAULT '',
	parentMenuItem VARCHAR(255) NOT NULL DEFAULT '',
	menuItemLink VARCHAR(255) NOT NULL DEFAULT '',
	menuItemDescription TEXT NOT NULL,
	menuItemIcon VARCHAR(255) NOT NULL DEFAULT '',
	showOrder int(10) NOT NULL default '0',
  	permissions text,
	PRIMARY KEY ( menuItemID ),
	UNIQUE KEY packageID (packageID, menuItem)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

CREATE TABLE wcf1_guthaben_prices
(
	priceItemID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
	packageID INT(10) UNSIGNED NOT NULL,
	priceItem VARCHAR(255) NOT NULL DEFAULT '',
	priceDescription VARCHAR(255) NOT NULL DEFAULT '',
	priceConstant VARCHAR(255) NOT NULL DEFAULT '',
	priceIsNegative TINYINT(1) NOT NULL DEFAULT 0,
	priceCurrency VARCHAR(100) NOT NULL DEFAULT '',
	PRIMARY KEY ( priceItemID ),
	UNIQUE KEY packageID (packageID, priceItem)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;