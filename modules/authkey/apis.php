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

if ($GLOBALS['authkeyConfigsList']['htaccess'])
    if (strpos($_SERVER['REQUEST_URI'], 'odules/')>0) {
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . XOOPS_URL . '/' . $GLOBALS['authkeyConfigsList']['baseurl'] . '/apis' . $GLOBALS['authkeyConfigsList']['endofurl']);
        exit(0);
    }

$xoopsOption['template_main'] = 'authkeys_apis.html';
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';
$GLOBALS['xoopsTpl']->assign('moddirname', basename(__DIR__));

$criteria = new Criteria('1', '1');
$criteria->setSort('`api-type` ASC, `api-http` ASC, `api-https`');
$criteria->setOrder('ASC');

foreach(xoops_getModuleHandler('apis', basename(__DIR__))->getObjects($criteria) as $api)
{
    $apiarr = array();
    foreach($api->getValues(array_keys($api->vars)) as $field => $value)
    {
        if (substr($field, 0, 5) == 'calls') {
            $apiarr[str_replace("-", "_", $field)] = number_format($value, 0);
        } elseif (in_array($field, array('online', 'offline'))) {
            if ($field = $api->getVar('status'))
                $apiarr[str_replace("-", "_", $field)] = authkey_getTimePeriod($value + ((time() > $api->getVar('checked') ? time() - $api->getVar('checked') : $api->getVar('checked') - time())));
            else
                $apiarr[str_replace("-", "_", $field)] = authkey_getTimePeriod($value);
        } elseif (in_array($field, array('stats-hour', 'stats-day', 'stats-week', 'stats-month', 'stats-quarter', 'stats-year', 'report-month', 'report-quarter', 'report-year', 'report-biannual', 'created', 'checked', 'checking', 'emailed'))) {
            $apiarr[str_replace("-", "_", $field)] = date("Y/m/d H:i:s", $value);
        } else {
            $apiarr[str_replace("-", "_", $field)] = $value;
        }
    }
    $apiarr['url'] = $api->getVar('api-'.$api->getVar('mode'));
    $GLOBALS['xoopsTpl']->append('apis', $apiarr);
}

$GLOBALS['xoopsTpl']->assign('apis_count', xoops_getModuleHandler('apis', basename(__DIR__))->getCount($criteria));
$GLOBALS['xoopsTpl']->assign('authkeys_module_version', $authkeyModule->getVar('version') / 100);
$GLOBALS['xoopsTpl']->assign('authkeys_module_namings', $authkeyModule->getVar('name'));

$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/assets/css/style.css');
if (is_file(XOOPS_ROOT_PATH . '/module/' . basename(__DIR__) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css'))
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/style.css');
else
    $GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(__DIR__) . '/language/english/style.css');
        
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'footer.php';