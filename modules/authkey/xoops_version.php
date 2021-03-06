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
$modversion['version']		= 1.11;
$modversion['author']       = 'Dr. Simon Antony Roberts <simon@snails.email';
$modversion['description']	= 'This module allows for the generation of authkeys for api\'s on xoops.org';
$modversion['credits']		= 'Dr. Simon Antony Roberts <simon@snails.email';;
$modversion['license']		= 'GPL2';
$modversion['official']		= true;
$modversion['image']		= 'assets/images/modlogo.png';
$modversion['dirname']		= basename(__DIR__);

$modversion['website'] 		= 'xoops.org';

$modversion['dirmoduleadmin'] = 'Frameworks/moduleclasses';
$modversion['icons16'] = 'modules/' . $modversion['dirname'] . '/assets/images/16x16';
$modversion['icons32'] = 'modules/' . $modversion['dirname'] . '/assets/images/32x32';

$modversion['release_info'] = "Stable 2018/05/17";
$modversion['release_file'] = "";
$modversion['release_date'] = "2018/05/17";

// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

// Tables created by sql file (without prefix!)
$modversion['tables'][0]	=  'authkey_apis';
$modversion['tables'][1]	=  'authkey_keys';
$modversion['tables'][2]	=  'authkey_statistics';
$modversion['tables'][3]	=  'authkey_users';

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
$modversion['templates'][$i]['file'] = 'authkeys_index.html';
$modversion['templates'][$i]['description'] = 'authkeys main index';
$i++;
$modversion['templates'][$i]['file'] = 'authkeys_key_view.html';
$modversion['templates'][$i]['description'] = 'authkeys key view';
$i++;
$modversion['templates'][$i]['file'] = 'authkeys_key_edit.html';
$modversion['templates'][$i]['description'] = 'authkeys key edit';
$i++;
$modversion['templates'][$i]['file'] = 'authkeys_key.html';
$modversion['templates'][$i]['description'] = 'authkeys key confirm';
$i++;
$modversion['templates'][$i]['file'] = 'authkeys_purchase.html';
$modversion['templates'][$i]['description'] = 'authkeys migrate to token purchases';
$i++;
$modversion['templates'][$i]['file'] = 'authkeys_apis.html';
$modversion['templates'][$i]['description'] = 'authkeys migrate to token purchases';

// Module Submenus
if (is_object($GLOBALS['xoopsUser']))
{
    $i=1;
    $modversion['sub'][$i]['name'] = _MI_AUTHKEY_APIS;
    $modversion['sub'][$i]['url'] = "apis.php";
    
    // Submenu Items
    $keys_handler =& xoops_getmodulehandler('keys', 'authkey');
    $criteria = new CriteriaCompo(new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid')));
    $criteria->setOrder('ASC');
    $criteria->setSort('`title`');
    $keys = $keys_handler->getObjects($criteria, true);
    foreach($keys as $key) {
        $i++;
        $modversion['sub'][$i]['name'] = $key->getVar('title');
        $modversion['sub'][$i]['url'] = "key.php?id=".$key->getVar('id')."&op=view";
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
$modversion['config'][$i]['name'] = 'api-reporting';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_API_REPORTING";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_API_REPORTING_DESC";
$modversion['config'][$i]['formtype'] = 'group_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array(XOOPS_GROUP_ADMIN=>XOOPS_GROUP_ADMIN);

$i++;
$modversion['config'][$i]['name'] = 'minimum-lines';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_MINUMUM_LINES";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_MINUMUM_LINES_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = mt_rand(2, 6);
$modversion['config'][$i]['options'] = array('1 Line of Data' => 1, '2 Lines of Data' => 2, '3 Lines of Data' => 3, '4 Lines of Data' => 4, '5 Lines of Data' => 5, '6 Lines of Data' => 6, '7 Lines of Data' => 7, '8 Lines of Data' => 8, '9 Lines of Data' => 9, '10 Lines of Data' => 10);

$i++;
$modversion['config'][$i]['name'] = 'tmp-path';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_TMP_PATH";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_TMP_PATH_DESC";
$modversion['config'][$i]['formtype'] = 'txt';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '/tmp';

$i++;
$modversion['config'][$i]['name'] = 'delete-seconds';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_DELETE_SECONDS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_DELETE_SECONDS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (3600*24*7*4*12*mt_rand(2,6));
$modversion['config'][$i]['options'] = array('After 2 Years' => (3600*24*7*4*12*2), 'After 3 Years' => (3600*24*7*4*12*3), 'After 4 Years' => (3600*24*7*4*12*4), 'After 5 Years' => (3600*24*7*4*12*5), 'After 6 Years' => (3600*24*7*4*12*6), 'After 7 Years' => (3600*24*7*4*12*7), 'After 8 Years' => (3600*24*7*4*12*8), 'After 9 Years' => (3600*24*7*4*12*9), 'After a Decade' => (3600*24*7*4*12*10));

$i++;
$modversion['config'][$i]['name'] = 'auto-generate';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_AUTOGENERATED";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_AUTOGENERATED_DESC";
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = false;

$i++;
$modversion['config'][$i]['name'] = 'auto-generate-seconds';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_AUTOGENERATED_SECONDS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_AUTOGENERATED_SECONDS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (mt_rand(1,9)*5)*60;
$modversion['config'][$i]['options'] = array('5 minutes' => (5*60), '10 minutes' => (10*60), '15 minutes' => (15*60), '20 minutes' => (20*60), '25 minutes' => (25*60) , '30 minutes' => (30*60), '35 minutes' => (35*60), '40 minutes' => (40*60), '45 minutes' => (45*60), '50 minutes' => (50*60) , '55 minutes' => (55*60));

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
$modversion['config'][$i]['options'] = array('5 minutes' => (5*60), '10 minutes' => (10*60), '15 minutes' => (15*60), '20 minutes' => (20*60), '25 minutes' => (25*60) , '30 minutes' => (30*60), '35 minutes' => (35*60), '40 minutes' => (40*60), '45 minutes' => (45*60), '50 minutes' => (50*60) , '55 minutes' => (55*60));

$i++;
$modversion['config'][$i]['name'] = 'preload-seconds';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PRELOAD_SECONDS";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PRELOAD_SECONDS_DESC";
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = (mt_rand(1,4)*5)*60;
$modversion['config'][$i]['options'] = array('5 minutes' => (5*60), '10 minutes' => (10*60), '15 minutes' => (15*60), '20 minutes' => (20*60), '25 minutes' => (25*60) , '30 minutes' => (30*60), '35 minutes' => (35*60), '40 minutes' => (40*60), '45 minutes' => (45*60), '50 minutes' => (50*60) , '55 minutes' => (55*60));

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
$modversion['config'][$i]['default'] = 200 * 24 * 7 * 4 * 12;

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
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_PURCHASE_NOMIAL";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_PURCHASE_NOMIAL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'USD';

$i++;
$modversion['config'][$i]['name'] = 'xpayment-url';
$modversion['config'][$i]['title'] = "_MI_AUTHKEY_XPAYMENT_URL";
$modversion['config'][$i]['description'] = "_MI_AUTHKEY_XPAYMENT_URL_DESC";
$modversion['config'][$i]['formtype'] = 'text';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = XOOPS_URL . '/modules/xpayment/';

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
