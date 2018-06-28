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

$adminmenu = array();
$i=1;
$adminmenu[$i]['icon'] = _MI_AUTHKEY_ADMENU0_ICON;
$adminmenu[$i]['image'] = _MI_AUTHKEY_ADMENU0_ICON;
$adminmenu[$i]['title'] = _MI_AUTHKEY_ADMENU0;
$adminmenu[$i]['link']  = "admin/index.php";
$i++;
$adminmenu[$i]['icon'] = _MI_AUTHKEY_ADMENU1_ICON;
$adminmenu[$i]['image'] = _MI_AUTHKEY_ADMENU1_ICON;
$adminmenu[$i]['title'] = _MI_AUTHKEY_ADMENU1;
$adminmenu[$i]['link']  = "admin/keys.php";
$i++;
$adminmenu[$i]['icon'] = _MI_AUTHKEY_ADMENU5_ICON;
$adminmenu[$i]['image'] = _MI_AUTHKEY_ADMENU5_ICON;
$adminmenu[$i]['title'] = _MI_AUTHKEY_ADMENU5;
$adminmenu[$i]['link']  = "admin/apis.php";
$i++;
$adminmenu[$i]['icon'] = _MI_AUTHKEY_ADMENU2_ICON;
$adminmenu[$i]['image'] = _MI_AUTHKEY_ADMENU2_ICON;
$adminmenu[$i]['title'] = _MI_AUTHKEY_ADMENU2;
$adminmenu[$i]['link']  = "admin/lestats.php";
$i++;
$adminmenu[$i]['icon'] = _MI_AUTHKEY_ADMENU3_ICON;
$adminmenu[$i]['image'] = _MI_AUTHKEY_ADMENU3_ICON;
$adminmenu[$i]['title'] = _MI_AUTHKEY_ADMENU3;
$adminmenu[$i]['link']  = "admin/permissions.php";
$i++;
$adminmenu[$i]['icon'] = _MI_AUTHKEY_ADMENU4_ICON;
$adminmenu[$i]['image'] = _MI_AUTHKEY_ADMENU4_ICON;
$adminmenu[$i]['title'] = _MI_AUTHKEY_ADMENU4;
$adminmenu[$i]['link']  = "admin/about.php";

?>