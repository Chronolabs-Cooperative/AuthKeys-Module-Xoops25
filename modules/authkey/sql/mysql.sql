#
# Table structure for table authkey_keys
#
#Create Table

CREATE TABLE `authkey_apis` (                   
	`id` MEDIUMINT(32) UNSIGNED NOT NULL AUTO_INCREMENT,  
	`api-name` VARCHAR(128) NOT NULL DEFAULT '',
	`api-type` VARCHAR(64) NOT NULL DEFAULT '',
	`api-version` VARCHAR(6) NOT NULL DEFAULT 'v1',
	`api-http` VARCHAR(128) NOT NULL DEFAULT '',
	`api-https` VARCHAR(128) NOT NULL DEFAULT '',
	`api-icon` VARCHAR(196) NOT NULL DEFAULT '',
	`api-write` ENUM('xoopskey', 'open', 'userpass') NOT NULL DEFAULT 'xoopskey',
	`api-read` ENUM('xoopskey', 'open', 'userpass') NOT NULL DEFAULT 'xoopskey',
	`mode` ENUM('http', 'https') NOT NULL DEFAULT 'http',
	`status` ENUM('online', 'offline') NOT NULL DEFAULT 'offline',
	`checked` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`checking` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`online` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`offline` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-hour` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-day` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-week` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-month` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-quarter` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-year` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-monthly` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-halfyear` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-fullyear` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-biannual` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`created` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`emailed` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `apitypestatus` (`api-type`,`status`),
	KEY `search` (`api-name`,`api-type`,`api-version`,`api-http`,`api-https`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

# Table structure for table authkey_keys
#
#Create Table

CREATE TABLE `authkey_keys` (                   
	`id` MEDIUMINT(32) UNSIGNED NOT NULL AUTO_INCREMENT,  
	`key` VARCHAR(128) NOT NULL DEFAULT '',
	`title` VARCHAR(64) NOT NULL DEFAULT '',
	`name` VARCHAR(64) NOT NULL DEFAULT '',
	`company` VARCHAR(64) NOT NULL DEFAULT '',
	`email` VARCHAR(196) NOT NULL DEFAULT '',
	`url` VARCHAR(255) NOT NULL DEFAULT '',
	`uid` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`limit-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '200',
	`limit-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '4800',
	`limit-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '33600',
	`limit-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '134400',
	`limit-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '403200',
	`limit-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '1612800',
	`stats-hour` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-day` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-week` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-month` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-quarter` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-year` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-monthly` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-halfyear` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-fullyear` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-biannual` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`created` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`issuing` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`quoting` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`emailed` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `keyuid` (`key`,`uid`),
	KEY `titlenamecompanyemailuid` (`title`,`name`,`company`,`email`,`uid`),
	KEY `search` (`key`,`uid`,`created`,`issuing`,`quoting`,`emailed`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;

#
# Table structure for table authkey_statistics
#
#Create Table

CREATE TABLE `authkey_statistics` (               
	`id` MEDIUMINT(196) UNSIGNED NOT NULL AUTO_INCREMENT,
	`api-id` MEDIUMINT(32) UNSIGNED NOT NULL DEFAULT '0',
	`key-id` MEDIUMINT(32) UNSIGNED NOT NULL DEFAULT '0',
	`uid` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',            
	`type` ENUM('hour','day','week','month','quarter','year','user-hour','user-day','user-week','user-month','user-quarter','user-year','api-hour','api-day','api-week','api-month','api-quarter','api-year') DEFAULT 'hour',
	`calls` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`limit` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`over` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`begining` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`finished` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),                               
	KEY `search` (`uid`,`type`,`begining`,`finished`)              
) ENGINE=INNODB DEFAULT CHARSET=utf8;

#
# Table structure for table authkey_keys
#
#Create Table

CREATE TABLE `authkey_users` (                   
	`uid` MEDIUMINT(32) UNSIGNED NOT NULL AUTO_INCREMENT,  
	`uname` VARCHAR(128) NOT NULL DEFAULT '',
	`calls-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`calls-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`overs-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '0',
	`limit-hour` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '200',
	`limit-day` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '4800',
	`limit-week` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '33600',
	`limit-month` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '134400',
	`limit-quarter` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '403200',
	`limit-year` MEDIUMINT(12) UNSIGNED NOT NULL DEFAULT '1612800',
	`stats-hour` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-day` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-week` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-month` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-quarter` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`stats-year` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-monthly` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-halfyear` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-fullyear` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`report-biannual` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`created` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`quoting` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	`emailed` INT(12) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`uid`),
	KEY `unameuid` (`uname`,`uid`),
	KEY `search` (`uname`,`uid`,`created`,`emailed`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;
