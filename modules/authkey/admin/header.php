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


    global $authkeyModule, $op, $mode, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions, $groups;

	require "../../../include/cp_header.php";
	
	require_once (dirname(dirname(dirname(dirname(__FILE__)))).'/include/cp_header.php');
	
	require_once(dirname(__DIR__) . DS . 'header.php');
	
	$myts =& MyTextSanitizer::getInstance();
	
	xoops_load('pagenav');	
	xoops_load('xoopslists');
	xoops_load('xoopsformloader');
	
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopsmailer.php');
	include_once $GLOBALS['xoops']->path('class'.DS.'xoopstree.php');
	
	if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
	        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
	        //return true;
	    }else{
	        echo authkey_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
	        //return false;
	    }
	$GLOBALS['authkeyImageIcon'] = XOOPS_URL .'/'. $GLOBALS['authkeyModule']->getInfo('icons16');
	$GLOBALS['authkeyImageAdmin'] = XOOPS_URL .'/'. $GLOBALS['authkeyModule']->getInfo('icons32');
	
	if ($GLOBALS['xoopsUser']) {
	    $moduleperm_handler =& xoops_gethandler('groupperm');
	    if (!$moduleperm_handler->checkRight('module_admin', $GLOBALS['authkeyModule']->getVar( 'mid' ), $GLOBALS['xoopsUser']->getGroups())) {
	        redirect_header(XOOPS_URL, 1, _NOPERM);
	        exit();
	    }
	} else {
	    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
	    exit();
	}
	
	if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
		include_once(XOOPS_ROOT_PATH."/class/template.php");
		$GLOBALS['xoopsTpl'] = new XoopsTpl();
	}
	
	$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['authkeyImageIcon']);
	$GLOBALS['xoopsTpl']->assign('pathImageAdmin', $GLOBALS['authkeyImageAdmin']);
	
	
?>