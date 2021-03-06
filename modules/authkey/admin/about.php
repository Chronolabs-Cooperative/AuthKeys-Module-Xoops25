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


	include ('header.php');
	
	xoops_loadlanguage('main', basename(dirname(__DIR__)));
	
	xoops_cp_header();
	$indexAdmin = new ModuleAdmin();
	echo $indexAdmin->addNavigation(basename($_SERVER['PHP_SELF']));	
	
	$paypalitemno='VOD106';
	$aboutAdmin = new ModuleAdmin();
	$about = $aboutAdmin->renderabout($paypalitemno, false);
	
	xoops_cp_footer();		
?>