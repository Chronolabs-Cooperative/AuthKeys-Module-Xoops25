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
    require_once __DIR__ . DS . 'apis.php';
    exit(0);
}

if ($GLOBALS['authkeyConfigsList']['htaccess'])
    if (strpos($_SERVER['REQUEST_URI'], 'odules/')>0) {
        header('HTTP/1.1 301 Moved Permanently'); 
        header('Location: ' . XOOPS_URL . '/' . $GLOBALS['authkeyConfigsList']['baseurl'] . '/index' . $GLOBALS['authkeyConfigsList']['endofurl']);
        exit(0);
    }

$xoopsOption['template_main'] = 'authkeys_index.html';
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';
$GLOBALS['xoopsTpl']->assign('moddirname', basename(__DIR__));

$criteria = new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid'));
$criteria->setSort('`title` ASC, `name` ASC, `company`');
$criteria->setOrder('ASC');

foreach(xoops_getModuleHandler('keys', basename(__DIR__))->getObjects($criteria) as $key)
{
    $keyarr = array();
    foreach($key->getValues(array_keys($key->vars)) as $field => $value)
    {
        if (substr($field, 0, 5) == 'calls' || substr($field, 0, 5) == 'limit'  || substr($field, 0, 5) == 'overs') {
            $keyarr[str_replace("-", "_", $field)] = number_format($value, 0);
        } elseif (in_array($field, array('stats-hour', 'stats-day', 'stats-week', 'stats-month', 'stats-quarter', 'stats-year', 'report-month', 'report-quarter', 'report-year', 'report-biannual', 'created', 'issuing', 'quoting', 'emailed'))) {
            $keyarr[str_replace("-", "_", $field)] = date("Y/m/d H:i:s", $value);
        } else { 
            $keyarr[str_replace("-", "_", $field)] = $value;
        }
    }
    $GLOBALS['xoopsTpl']->append('authkeys', $keyarr);
}

$GLOBALS['xoopsTpl']->assign('authkeys_count', xoops_getModuleHandler('keys', basename(__DIR__))->getCount($criteria));
$GLOBALS['xoopsTpl']->assign('authkeys_module_version', $authkeyModule->getVar('version') / 100);
$GLOBALS['xoopsTpl']->assign('authkeys_module_namings', $authkeyModule->getVar('name'));
$GLOBALS['xoopsTpl']->assign('authkeys_newkey_form', getHTMLForm('newkey'   ));
// Permissions
$GLOBALS['xoopsTpl']->assign('allow_creating', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWCREATING, false, $GLOBALS['xoopsUser']->getVar('uid')));
$GLOBALS['xoopsTpl']->assign('allow_viewing', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWVIEWING, false, $GLOBALS['xoopsUser']->getVar('uid')));
$GLOBALS['xoopsTpl']->assign('allow_reissued', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWREISSUED, false, $GLOBALS['xoopsUser']->getVar('uid')));
$GLOBALS['xoopsTpl']->assign('allow_editing', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWEDITING, false, $GLOBALS['xoopsUser']->getVar('uid')));
$GLOBALS['xoopsTpl']->assign('allow_deleting', authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWDELETING, false, $GLOBALS['xoopsUser']->getVar('uid')));

$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/assets/css/style.css');
if (is_file(XOOPS_ROOT_PATH . '/module/' . basename(__DIR__) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
else
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/language/english/style.css');

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'footer.php';
        