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



$i=0;

$modversion['name']		    = 'API Authkeys';
$modversion['version']		= 1.07;
$modversion['author']       = 'Dr. Simon Antony Roberts <simon@snails.email';
$modversion['description']	= 'This module allows for the generation of authkeys for api\'s on xoops.org';
$modversion['credits']		= 'Dr. Simon Antony Roberts <simon@snails.email';;
$modversion['license']		= 'GPL2';
$modversion['official']		= true;
$modversion['image']		= 'images/modlogo.png';
$modversion['dirname']		= 'authkey';

$modversion['website'] 		= 'xoops.org';

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'Frameworks/moduleclasses/icons/16';
$modversion['icons32'] = 'Frameworks/moduleclasses/icons/32';

$modversion['release_info'] = "Stable 2018/05/17";
$modversion['release_file'] = "";
$modversion['release_date'] = "2018/05/17";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0]	=  'authkey_keys';
$modversion['tables'][1]	=  'authkey_statistics';

// Admin things
$modversion['hasAdmin']		= true;
$modversion['adminindex']	= 'admin/index.php';
$modversion['adminmenu']	= 'admin/menu.php';
$modversion['system_menu'] 	= true;

// Search
$modversion['hasSearch'] 	= false;
$modversion['search']['file'] = '';
$modversion['search']['func'] = '';

// Comments
$modversion['hasComments'] = true;
$modversion['comments']['itemName'] = 'id';
$modversion['comments']['pageName'] = 'key.php';

// Menu
$modversion['onInstall'] = '';
$modversion['onUpdate'] = '';

// Menu
$modversion['hasMain'] = true;

// Smarty
$modversion['use_smarty'] = true;

// Templates
$i=1;
$modversion['templates'][$i]['file'] = 'authkeys_api_help.html';
$modversion['templates'][$i]['description'] = 'api help reference';
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_BREADCRUMB;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_BREADCRUMB_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_CPANEL_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_CPANEL_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_CPANEL_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_CPANEL_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_CPANEL_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_CPANEL_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_CPANEL_JSON_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_CPANEL_JSON_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_CPANEL_JSON_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_CPANEL_JSON_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_JSON_ADDEDITPAGE;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_JSON_ADDEDITPAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_JSON_ADDEDITCATEGORY_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_JSON_ADDEDITBLOCK;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_JSON_ADDEDITBLOCK_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_MANAGE;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_MANAGE_DESC;
$i++;
$modversion['templates'][$i]['file'] = _MI_AUTHKEY_TEMPLATE_INDEX_PASSWORD;
$modversion['templates'][$i]['description'] = _MI_AUTHKEY_TEMPLATE_INDEX_PASSWORD_DESC;


if (is_object($GLOBALS['xoopsUser']))
{    
    // Submenu Items
    $keys_handler =& xoops_getmodulehandler('keys', 'authkey');
    $criteria = new CriteriaCompo(new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid')));
    $criteria->setOrder('created');
    $criteria->setSort('ASC');
    $keys = $keys_handler->getObjects($criteria, true);
    foreach($keys as $key) {
        $modversion['sub'][$i]['name'] = $key->getVar('title');
        $modversion['sub'][$i]['url'] = "key.php?id=".$key->getVar('id');
    	$i++;	
    }
}

// Blocks
$modversion["blocks"][1]    = array(
    "file"            => "authkey_over.php",
    "name"            => "Over Limit API Calling",
    "description"     => "Show Over Limit API Calling",
    "show_func"       => "authkey_over_show",
    "edit_func"       => "authkey_over_edit",
    "options"         => "",
    "template"        => "authkey_over.html",
    );

$i++;
$modversion['config'][$i]['name'] = 'auto-generate';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_AUTOGENERATED";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_AUTOGENERATED_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'auto-generate-seconds';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_AUTOGENERATED_SECONDS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_AUTOGENERATED_SECONDS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (mt_rand(1,9)*5)*60;
$modversion['config'][$i]['options'] = array((5*60) => '5 minutes', (10*60) => '10 minutes', (15*60) => '15 minutes', (20*60) => '20 minutes', (25*60) => '25 minutes', (30*60) => '30 minutes', (35*60) => '35 minutes', (40*60) => '40 minutes', (45*60) => '45 minutes', (50*60) => '50 minutes', (55*60) => '55 minutes');

$i++;
$modversion['config'][$i]['name'] = 'number-auto-generated';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_NUMBER_AUTOGENERATED";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_NUMBER_AUTOGENERATED_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(13,69);

$i++;
$modversion['config'][$i]['name'] = 'polling-seconds';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_POLLING_SECONDS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_POLLING_SECONDS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (mt_rand(1,4)*5)*60;
$modversion['config'][$i]['options'] = array((5*60) => '5 minutes', (10*60) => '10 minutes', (15*60) => '15 minutes', (20*60) => '20 minutes', (25*60) => '25 minutes', (30*60) => '30 minutes', (35*60) => '35 minutes', (40*60) => '40 minutes', (45*60) => '45 minutes', (50*60) => '50 minutes', (55*60) => '55 minutes');

$i++;
$modversion['config'][$i]['name'] = 'preload-seconds';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PRELOAD_SECONDS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PRELOAD_SECONDS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (mt_rand(1,4)*5)*60;
$modversion['config'][$i]['options'] = array((5*60) => '5 minutes', (10*60) => '10 minutes', (15*60) => '15 minutes', (20*60) => '20 minutes', (25*60) => '25 minutes', (30*60) => '30 minutes', (35*60) => '35 minutes', (40*60) => '40 minutes', (45*60) => '45 minutes', (50*60) => '50 minutes', (55*60) => '55 minutes');

$i++;
$modversion['config'][$i]['name'] = 'limited';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMITED";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMITED_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = true;

$i++;
$modversion['config'][$i]['name'] = 'limit-hour';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMIT_HOUR";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMIT_HOUR_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200;

$i++;
$modversion['config'][$i]['name'] = 'limit-day';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMIT_DAY";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMIT_DAY_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200 * 24;

$i++;
$modversion['config'][$i]['name'] = 'limit-week';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMIT_WEEK";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMIT_WEEK_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200 * 24 * 7;

$i++;
$modversion['config'][$i]['name'] = 'limit-month';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMIT_MONTH";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMIT_MONTH_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200 * 24 * 7 * 4;

$i++;
$modversion['config'][$i]['name'] = 'limit-quarter';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMIT_QUARTER";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMIT_QUARTER_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200 * 24 * 7 * 4 * 3;

$i++;
$modversion['config'][$i]['name'] = 'limit-year';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_LIMIT_YEAR";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_LIMIT_YEAR_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 200 * 24 * 7 * 4 * 3 * 4;

$i++;
$modversion['config'][$i]['name'] = 'purchase-hour';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_HOUR";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_HOUR_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 350;

$i++;
$modversion['config'][$i]['name'] = 'purchase-day';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_DAY";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_DAY_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 350 * 24;

$i++;
$modversion['config'][$i]['name'] = 'purchase-week';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_WEEK";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_WEEK_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 350 * 24 * 7;

$i++;
$modversion['config'][$i]['name'] = 'purchase-month';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_MONTH";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_MONTH_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 350 * 24 * 7 * 4;

$i++;
$modversion['config'][$i]['name'] = 'purchase-quarter';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_QUARTER";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_QUARTER_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 350 * 24 * 7 * 4 * 3;

$i++;
$modversion['config'][$i]['name'] = 'purchase-year';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_YEAR";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_YEAR_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 350 * 24 * 7 * 4 * 12;
$i++;
$modversion['config'][$i]['name'] = 'purchase-price';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_PRICE";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_PRICE_DESC";
$modversion['config'][$i]['formtype'] = 'int';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 35;

$i++;
$modversion['config'][$i]['name'] = 'purchase-nomial';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_CURRENCY";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_CURRENCY_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'USD';

$i++;
$modversion['config'][$i]['name'] = 'htaccess';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_HTACCESS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_HTACCESS_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'baseurl';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_BASEURL";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_BASEURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'xoopskeys';

$i++;
$modversion['config'][$i]['name'] = 'endofurl';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_ENDOFURL";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_ENDOFURL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.html';

$i++;
$modversion['config'][$i]['name'] = 'endofurl_pdf';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_ENDOFURLPDF";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_ENDOFURLPDF_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '.pdf';
?>
