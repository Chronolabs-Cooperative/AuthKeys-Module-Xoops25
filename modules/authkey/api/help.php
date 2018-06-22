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

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'header.php';

$xoopsOption['template_main'] = 'authkeys_api_help.html';
require_once dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'header.php';

$GLOBALS['xoopsTpl']->assign('authkeys_module_version', $authkeyModule->getVar('version'));
$GLOBALS['xoopsTpl']->assign('authkeys_module_namings', $authkeyModule->getVar('name'));

$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/css/api-style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop Bold/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop Bold Italic/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop Italic/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop Superwide Boldish/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop Thin/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Labtop Unicase/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/LHF Matthews Thin/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Life BT Bold/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Life BT Bold Italic/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Prestige Elite/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Prestige Elite Bold/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/media/Prestige Elite Normal/style.css');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/css/gradients.php');
$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/module/' . basename(dirname(dirname(__DIR__))) . '/assets/css/shadowing.php');

$GLOBALS['xoopsTpl']->assign('form_getkey', getHTMLForm('getkey'));
$GLOBALS['xoopsTpl']->assign('form_htmlchars_getkey', htmlspecialchars(getHTMLForm('getkey')));
$GLOBALS['xoopsTpl']->assign('form_verify', getHTMLForm('verify'));
$GLOBALS['xoopsTpl']->assign('form_htmlchars_verify', htmlspecialchars(getHTMLForm('verify')));

require_once dirname(dirname(dirname(dirname(__DIR__)))) . DIRECTORY_SEPARATOR . 'footer.php';
?>

