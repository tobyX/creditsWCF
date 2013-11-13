DROP TABLE IF EXISTS credits1_account_type;
CREATE TABLE credits1_account_type
(
	accountTypeID INT(10) unsigned NOT NULL auto_increment,
	allowNegative TINYINT(1) NOT NULL DEFAULT 0,
	debitInterest FLOAT(11) NOT NULL DEFAULT 10.4,
	interestCredits FLOAT(11) NOT NULL DEFAULT 0.4,
	PRIMARY KEY (accountTypeID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS credits1_account;
CREATE TABLE credits1_account
(
	accountID INT(10) unsigned NOT NULL auto_increment,
	userID INT(10) unsigned NOT NULL DEFAULT 0,
	accountTypeID INT(10) unsigned NOT NULL DEFAULT 0,
	credits FLOAT(11) NOT NULL DEFAULT 0.0,
	defaultAccount TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (accountID),
	KEY userID (userID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS credits1_statement;
CREATE TABLE credits1_statement
(
	statementID INT(10) unsigned NOT NULL auto_increment,
	accountID INT(10) unsigned NOT NULL DEFAULT 0,
	langvar VARCHAR(100) NOT NULL DEFAULT '',
	text VARCHAR(255) NOT NULL DEFAULT '',
	link VARCHAR(100) NOT NULL DEFAULT '',
	credits FLOAT(11) NOT NULL DEFAULT 0.0,
	time INT(10) unsigned NOT NULL DEFAULT 0,
	deleted TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (statementID),
	KEY userID (accountID)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS credits1_price;
CREATE TABLE credits1_price
(
	priceID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	packageID INT(10) UNSIGNED NOT NULL,
	item VARCHAR(255) NOT NULL DEFAULT '',
	description VARCHAR(255) NOT NULL DEFAULT '',
	price float NOT NULL DEFAULT 0.0,
	currency VARCHAR(30) NOT NULL DEFAULT '',
	PRIMARY KEY ( priceID ),
	UNIQUE KEY packageID (packageID, item)
) ENGINE = MYISAM DEFAULT CHARSET=utf8;

ALTER TABLE credits1_price ADD FOREIGN KEY (packageID) REFERENCES wcf1_package (packageID) ON DELETE CASCADE;
ALTER TABLE credits1_statement ADD FOREIGN KEY (accountID) REFERENCES credits1_account (accountID) ON DELETE CASCADE;
ALTER TABLE credits1_account ADD FOREIGN KEY (userID) REFERENCES wcf1_user (userID) ON DELETE CASCADE;
ALTER TABLE credits1_account ADD FOREIGN KEY (accountTypeID) REFERENCES credits1_account_type (accountTypeID) ON DELETE CASCADE;
