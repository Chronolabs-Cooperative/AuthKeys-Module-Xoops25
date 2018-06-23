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

global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'header.php';

if (!is_object($GLOBALS['xoopsUser']))
{
    redirect_header(XOOPS_URL . '/user.php', 8, _MN_AUTHKEY_LOGINREQUIRED);
    exit(0);
}

$xoopsOption['template_main'] = 'authkeys_index.html';
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';

$criteria = new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid'));
$criteria->setSort('`title` ASC, `name` ASC, `company`');
$criteria->setOrder('ASC');

foreach(xoops_getModuleHandler('keys', basename(__DIR__))->getObjects($criteria) as $key)   
    $GLOBALS['xoopsTpl']->append('keys', $key->getValues(array_keys($key->vars)));

$GLOBALS['xoopsTpl']->assign('authkeys_count', xoops_getModuleHandler('keys', basename(__DIR__))->getCount($criteria));
$GLOBALS['xoopsTpl']->assign('authkeys_allow_creating', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWCREATING, false, $GLOBALS['xoopsUser']->getVar('uid')));
$GLOBALS['xoopsTpl']->assign('authkeys_allow_viewing', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWVIEWING, false, $GLOBALS['xoopsUser']->getVar('uid')));
$GLOBALS['xoopsTpl']->assign('authkeys_module_version', $authkeyModule->getVar('version'));
$GLOBALS['xoopsTpl']->assign('authkeys_module_namings', $authkeyModule->getVar('name'));

$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/assets/css/style.css');
if (is_file(XOOPS_ROOT_PATH . '/module/' . basename(__DIR__) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
else
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/language/english/style.css');
        