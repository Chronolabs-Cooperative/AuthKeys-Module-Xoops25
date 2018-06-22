<?php
/**
 * Authkey API Authentication Keys for xoops.org
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       (c) 2000-2019 Chronolabs Cooperative (8Bit.snails.email)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             authkey
 * @since               1.0.7
 * @author              Simon Antony Roberts <wishcraft@users.sourceforge.net>
 * @link                https://sourceforge.net/p/xoops/svn/HEAD/tree/XoopsModules/authkey
 */




    // Email Subjects
    define('_MI_AUTHKEY_SUBJECT_ISSUINGKEY','Xoops.org ~ Issuing API Key: /?xoopskey=%s');
    define('_MI_AUTHKEY_SUBJECT_LIMITREACHED','Xoops.org ~ %s Limit of API\'s Polling Reached over by: %s');
    
    // Periodically Based Constants
    define('_MI_AUTHKEY_PERIODICALLY_HOUR', 'Hourly');
    define('_MI_AUTHKEY_PERIODICALLY_DAY', 'Daily');
    define('_MI_AUTHKEY_PERIODICALLY_WEEK', 'Weekly');
    define('_MI_AUTHKEY_PERIODICALLY_MONTH', 'Monthly');
    define('_MI_AUTHKEY_PERIODICALLY_QUARTER', 'Quarterly');
    define('_MI_AUTHKEY_PERIODICALLY_YEAR', 'Yearly');
    
    // Periodical Based Constants
    define('_MI_AUTHKEY_PERIODICAL_HOUR', 'Hour');
    define('_MI_AUTHKEY_PERIODICAL_DAY', 'Day');
    define('_MI_AUTHKEY_PERIODICAL_WEEK', 'Week');
    define('_MI_AUTHKEY_PERIODICAL_MONTH', 'Month');
    define('_MI_AUTHKEY_PERIODICAL_QUARTER', 'Quarter');
    define('_MI_AUTHKEY_PERIODICAL_YEAR', 'Year');
    
	// MENUs
	define('_MI_AUTHKEY_ADMENU1','Manage Content');
	define('_MI_AUTHKEY_ADMENU2','Add Content');
	define('_MI_AUTHKEY_ADMENU3','Manage Categories');
	define('_MI_AUTHKEY_ADMENU4','Add Category');
	define('_MI_AUTHKEY_ADMENU5','Manage Inheritable Blocks');
	define('_MI_AUTHKEY_ADMENU6','Add Inheritable Block');	
	define('_MI_AUTHKEY_ADMENU7','Permissions');

	// MENU ICONS?IMAGES
	define('_MI_AUTHKEY_ADMENU1_ICON','images/manage.xcenter.png');
	define('_MI_AUTHKEY_ADMENU2_ICON','images/add.xcenter.png');
	define('_MI_AUTHKEY_ADMENU3_ICON','images/manage.categories.png');
	define('_MI_AUTHKEY_ADMENU4_ICON','images/add.category.png');
	define('_MI_AUTHKEY_ADMENU5_ICON','images/manage.inheritable.blocks.png');
	define('_MI_AUTHKEY_ADMENU6_ICON','images/add.inheritable.block.png');	
	define('_MI_AUTHKEY_ADMENU7_ICON','images/permissions.png');
	
	// LANGUAGE DESCRIPTIONS
	define('_MI_AUTHKEY_LIMITED','API Are Limited to Calls Per Period');
	define('_MI_AUTHKEY_LIMITED_DESC','When this is enabled the API are limited to the number of calls that can be done to them per period!');
	define('_MI_AUTHKEY_LIMIT_HOUR','API Calls Allowed Hourly');
	define('_MI_AUTHKEY_LIMIT_HOUR_DESC','This is the number of calls that can be made in an hour by default.');
	define('_MI_AUTHKEY_LIMIT_DAY','API Calls Allowed Daily');
	define('_MI_AUTHKEY_LIMIT_DAY_DESC','This is the number of calls that can be made in a day by default.');
	define('_MI_AUTHKEY_LIMIT_WEEK','API Calls Allowed Weekly');
	define('_MI_AUTHKEY_LIMIT_WEEK_DESC','This is the number of calls that can be made in a week by default.');
	define('_MI_AUTHKEY_LIMIT_MONTH','API Calls Allowed Monthly');
	define('_MI_AUTHKEY_LIMIT_MONTH_DESC','This is the number of calls that can be made in a month by default.');	
	define('_MI_AUTHKEY_LIMIT_QUARTER','API Calls Allowed Quarterly');
	define('_MI_AUTHKEY_LIMIT_QUARTER_DESC','This is the number of calls that can be made in a quarter of a year by default.');	
	define('_MI_AUTHKEY_LIMIT_YEAR','API Calls Allowed Yearly');
	define('_MI_AUTHKEY_LIMIT_YEAR_DESC','This is the number of calls that can be made in a year by default.');	
	define('_MI_AUTHKEY_PURCHASE_HOUR','Purchase to increase limit hourly by');
	define('_MI_AUTHKEY_PURCHASE_HOUR_DESC','This is the number of calls you can increase all the limits by hour with a one off purchase through <em>xpayment</em>');	
	define('_MI_AUTHKEY_PURCHASE_PRICE','Purchase price to increase limit');
	define('_MI_AUTHKEY_PURCHASE_PRICE_DESC','This is the one off purchase price for calling tokens by hourly+++');	
	define('_MI_AUTHKEY_PURCHASE_CURRENCY','Purchase price currency');
	define('_MI_AUTHKEY_PURCHASE_CURRENCY_DESC','The currency use for the one off purchase!');	
	define('_MI_AUTHKEY_HTACCESS','Enabled HTACCESS SEO');
	define('_MI_AUTHKEY_HTACCESS_DESC','This enables SEO');
	define('_MI_AUTHKEY_BASEURL','Base URL for SEO');
	define('_MI_AUTHKEY_BASEURL_DESC','Base URL for SEO');
	define('_MI_AUTHKEY_ENDOFURL','End of URL');
	define('_MI_AUTHKEY_ENDOFURL_DESC','File Extension to HTML Files');
	define('_MI_AUTHKEY_ENDOFURLPDF','End of URL');
	define('_MI_AUTHKEY_ENDOFURLPDF_DESC','File Extension to Adobe Acrobat (PDF) Files');

	// Version 2.16
	//FUNCTIOnAL PAGE OpERATORs -- DO NOT CHANGE
	define('_MI_AUTHKEY_URL_OP_DASHBOARD','dashboard');
	define('_MI_AUTHKEY_URL_OP_ABOUT','about');
	
	// MENUs
	define('_MI_AUTHKEY_ADMENU0','Dashboard');
	define('_MI_AUTHKEY_ADMENU8','About XCentre');
	
	// MENU ICONS?IMAGES
	define('_MI_AUTHKEY_ADMENU0_ICON','../../Frameworks/moduleclasses/icons/32/home.png');
	define('_MI_AUTHKEY_ADMENU8_ICON','../../Frameworks/moduleclasses/icons/32/about.png');
		
?>