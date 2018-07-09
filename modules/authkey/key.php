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

$odds = $inner = array();
foreach($_GET as $key => $values) {
    if (!isset($inner[$key])) {
        $inner[$key] = $values;
    } elseif (!in_array(!is_array($values)?$values:md5(json_encode($values, true)), array_keys($odds[$key]))) {
        if (is_array($values)) {
            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
        } else {
            $odds[$key][$inner[$key] = $values] = "$values--$key";
        }
    }
}
foreach($_POST as $key => $values) {
    if (!isset($inner[$key])) {
        $inner[$key] = $values;
    } elseif (!in_array(!is_array($values)?$values:md5(json_encode($values, true)), array_keys($odds[$key]))) {
        if (is_array($values)) {
            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
        } else {
            $odds[$key][$inner[$key] = $values] = "$values--$key";
        }
    }
}
foreach(parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'], '?')?'&':'?').$_SERVER['QUERY_STRING'], PHP_URL_QUERY) as $key => $values) {
    if (!isset($inner[$key])) {
        $inner[$key] = $values;
    } elseif (!in_array(!is_array($values)?$values:md5(json_encode($values, true)), array_keys($odds[$key]))) {
        if (is_array($values)) {
            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
        } else {
            $odds[$key][$inner[$key] = $values] = "$values--$key";
        }
    }
}

$keysHandler = xoops_getModuleHandler('keys', basename(__DIR__));
$key = $keysHandler->get($inner['id']);

if ($key->getVar('uid') != $GLOBALS['xoopsUser']->getVar('uid') && !$GLOBALS['xoopsUser']->isAdmin())
{
    redirect_header(XOOPS_URL . '/user.php', 8, _MN_AUTHKEY_LOGINREQUIRED);
    exit(0);
}

switch($inner['op'])
{
    case "newkey":

        if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWCREATING, false, $GLOBALS['xoopsUser']->getVar('uid'))){
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_PERMREQUIREDFORKEY);
            exit(0);
        }
        if (!strlen($inner['title'])) {
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_TITLEREQUIRED);
            exit(0);
        }
        if (!strlen($inner['name'])) {
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_NAMEREQUIRED);
            exit(0);
        }
        if (!strlen($inner['url'])) {
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_URLREQUIRED);
            exit(0);
        }
        if (!strlen($inner['email']) || !checkEmail($inner['email'])) {
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_EMAILREQUIRED);
            exit(0);
        }
        $object = $keysHandler->create();
        $object->setVar('title', $inner['title']);
        $object->setVar('name', $inner['name']);
        $object->setVar('company', $inner['company']);
        $object->setVar('url', $inner['url']);
        $object->setVar('email', $inner['email']);
        $keysHandler->insert($object);
        
        redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_KEYCREATED);
        exit(0);
    case "confirm":
        switch($inner['mode'])
        {
            case "delete":
                if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWDELETING, false, $GLOBALS['xoopsUser']->getVar('uid'))){
                    redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_PERMREQUIREDFORKEY);
                    exit(0);
                }
                $keysHandler->delete($key);
                redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, sprintf(_MN_AUTHKEY_KEYDELETED, $key->getVar('title'), $key->getVar('name')));
                exit(0);
                break;
            case "reissue":
                if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWREISSUED, false, $GLOBALS['xoopsUser']->getVar('uid'))){
                    redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_PERMREQUIREDFORKEY);
                    exit(0);
                }
                $key->setVar('key', authkey_getAuthKey());
                $keysHandler->insert($key);
                redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, sprintf(_MN_AUTHKEY_KEYREISSUED, $key->getVar('title'), $key->getVar('name')));
                break;
        }
    default:
    case "view":
        $xoopsOption['template_main'] = 'authkeys_key_view.html';
        break;
    case "edit":
        $xoopsOption['template_main'] = 'authkeys_key_edit.html';
        break;
    case "reissue":
        if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWREISSUED, false, $GLOBALS['xoopsUser']->getVar('uid'))){
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_PERMREQUIREDFORKEY);
            exit(0);
        }
        $xoopsOption['template_main'] = 'authkeys_key.html';
        break;
    case "delete":
        if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWDELETING, false, $GLOBALS['xoopsUser']->getVar('uid'))){
            redirect_header(XOOPS_URL . '/' . basename(__DIR__) . '/index.php', 8, _MN_AUTHKEY_PERMREQUIREDFORKEY);
            exit(0);
        }
        $xoopsOption['template_main'] = 'authkeys_key.html';
        break;
}

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';

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
$GLOBALS['xoopsTpl']->assign('key', $keyarr);
$GLOBALS['xoopsTpl']->assign('authkeys_module_version', $authkeyModule->getVar('version'));
$GLOBALS['xoopsTpl']->assign('authkeys_module_namings', $authkeyModule->getVar('name'));

$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(__DIR__)) . '/assets/css/api-style.css');
if (is_file(XOOPS_ROOT_PATH . '/module/' . basename(dirname(__DIR__)) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(__DIR__)) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
else
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(__DIR__)) . '/language/english/style.css');

switch($inner['op'])
{
    case "reissue":
        $GLOBALS['xoopsTpl']->assign('authkeys_op', _MN_AUTHKEY_KEYS_OP_REISSUE); 
        $GLOBALS['xoopsTpl']->assign('confirm', xoops_confirm(array("op" => 'confirm', 'mode' => $inner['op'], 'id' => $inner['id']), XOOPS_URL . $_SERVER['REQUEST_URI'], sprintf(_MN_AUTHKEYS_CONFIRM_REISSUE, $key->getVar('title'), $key->getVar('name'), $key->getVar('email'))));
        break;
    case "delete":
        $GLOBALS['xoopsTpl']->assign('authkeys_op', _MN_AUTHKEY_KEYS_OP_DELETE);
        $GLOBALS['xoopsTpl']->assign('confirm', xoops_confirm(array("op" => 'confirm', 'mode' => $inner['op'], 'id' => $inner['id']), XOOPS_URL . $_SERVER['REQUEST_URI'], sprintf(_MN_AUTHKEYS_CONFIRM_DELETE, $key->getVar('title'), $key->getVar('name'), $key->getVar('key'))));
        break;
}
    
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'footer.php';