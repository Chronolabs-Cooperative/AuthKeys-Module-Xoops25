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


    require_once ('header.php');
    
    xoops_loadlanguage('main', basename(dirname(__DIR__)));
    
    require_once $GLOBALS['xoops']->path('class'.DS.'xoopsform'.DS.'grouppermform.php');
    
    xoops_cp_header();
    $indexAdmin = new ModuleAdmin();
    echo $indexAdmin->addNavigation(basename($_SERVER['PHP_SELF']));	
    
    $permtypes = array(	_MI_AUTHKEY_PERM_UNLIMITEDCALLS_ID => _MI_AUTHKEY_PERM_UNLIMITEDCALLS_DESC,
                        _MI_AUTHKEY_PERM_INCREASEONAVG_ID => _MI_AUTHKEY_PERM_INCREASEONAVG_DESC,
                        _MI_AUTHKEY_PERM_ALLOWPURCHASING_ID => _MI_AUTHKEY_PERM_ALLOWPURCHASING_DESC,
                        _MI_AUTHKEY_PERM_ALLOWCREATING_ID => _MI_AUTHKEY_PERM_ALLOWCREATING_DESC,
                        _MI_AUTHKEY_PERM_ALLOWREISSUED_ID => _MI_AUTHKEY_PERM_ALLOWREISSUED_DESC,
                        _MI_AUTHKEY_PERM_ALLOWVIEWING_ID => _MI_AUTHKEY_PERM_ALLOWVIEWING_DESC,
                        _MI_AUTHKEY_PERM_ALLOWEDITING_ID => _MI_AUTHKEY_PERM_ALLOWEDITING_DESC,
                        _MI_AUTHKEY_PERM_ALLOWDELETING_ID => _MI_AUTHKEY_PERM_ALLOWDELETING_DESC,
                        _MI_AUTHKEY_PERM_STOPISSUINGKEY_ID => _MI_AUTHKEY_PERM_STOPISSUINGKEY_DESC,
                        _MI_AUTHKEY_PERM_EMAILUSERMONTHLY_ID => _MI_AUTHKEY_PERM_EMAILUSERMONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILUSER6MONTHLY_ID => _MI_AUTHKEY_PERM_EMAILUSER6MONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILUSER12MONTHLY_ID => _MI_AUTHKEY_PERM_EMAILUSER12MONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILUSER24MONTHLY_ID => _MI_AUTHKEY_PERM_EMAILUSER24MONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILOWNERMONTHLY_ID => _MI_AUTHKEY_PERM_EMAILOWNERMONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILOWNER6MONTHLY_ID => _MI_AUTHKEY_PERM_EMAILOWNER6MONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILOWNER12MONTHLY_ID => _MI_AUTHKEY_PERM_EMAILOWNER12MONTHLY_DESC,
                        _MI_AUTHKEY_PERM_EMAILOWNER24MONTHLY_ID => _MI_AUTHKEY_PERM_EMAILOWNER24MONTHLY_DESC
    );
								
    $form_view = new XoopsGroupPermForm(_MI_AUTHKEY_PERM_FORMTITLE, $GLOBALS['xoopsModule']->getVar('mid'), _MI_AUTHKEY_PERM_AUTHKEY, "Permissions: " . $GLOBALS['xoopsModule']->getVar('name'), '', true);
	foreach ($permtypes as $id => $title) {
		$form_view->addItem($id, $title);
	} 
	echo $form_view->render();
	xoops_cp_footer();

?>