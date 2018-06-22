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
    
    require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'mainfile.php';
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'functions.php';
	
	$myts =& MyTextSanitizer::getInstance();
	
	if (empty($authkeyModule))
	{
	    if (is_a($authkeyModule = xoops_getHandler('module')->getByDirname(basename(__DIR__)), "XoopsModule"))
	    {
	        if (empty($authkeyConfigsList))
	        {
	            $authkeyConfigsList = authkey_load_config();
	        }
	        if (empty($authkeyConfigs))
	        {
	            $authkeyConfigs = xoops_getHandler('config')->getConfigs(new Criteria('conf_modid', $authkeyModule->getVar('mid')));
	        }
	        if (empty($authkeyConfigsOptions) && !empty($authkeyConfigs))
	        {
	            foreach($authkeyConfigs as $key => $config)
	                $authkeyConfigsOptions[$config->getVar('conf_name')] = $config->getConfOptions();
	        }
	    }
	}
	
	$gperm_handler =& xoops_gethandler('groupperm');
	$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);

	$op = (isset($_REQUEST['op']))?strtolower($_REQUEST['op']):'';
	$mode = (isset($_REQUEST['mode']))?strtolower($_REQUEST['mode']):_XTR_PERM_MODE_VIEW;

	
?>