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




/**
 * Profile core preloads
 *
 * @copyright       (c) 2000-2016 XOOPS Project (www.xoops.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @author              trabis <lusopoemas@gmail.com>
 */
class AuthkeyAutoPreload extends XoopsPreloadItem
{
    
    /**
     * @param $args
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        xoops_loadLanguage('modinfo', basename(dirname(__DIR__)));
        
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'header.php';
        
        if (is_object($GLOBALS['xoopsUser']) && $GLOBALS['authkeyConfigsList']['auto-generate'] == true)
        {
            $criteria = new Criteria('uid', $GLOBALS['xoopsUser']->getVar('uid'));
            if (authkeys_checkperm(_MI_AUTHKEY_PERM_STOPISSUINGKEY, false, $GLOBALS['xoopsUser']->getVar('uid')) && xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->getCount($criteria) == 0)
            {
                $key = xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->create();
                $key->setVar('email', $GLOBALS['xoopsUser']->getVar('email'));
                $key->setVar('title', sprintf(_MI_AUTHKEY_KEY_TITLE, $GLOBALS['xoopsUser']->getVar('uname')));
                $key->setVar('name', (strlen($GLOBALS['xoopsUser']->getVar('name'))==0?$GLOBALS['xoopsUser']->getVar('uname'):$GLOBALS['xoopsUser']->getVar('name')));
                $key->setVar('company', $GLOBALS['xoopsConfig']['sitename']);
                $key->setVar('url', (strlen($GLOBALS['xoopsUser']->getVar('url'))==0?XOOPS_URL:$GLOBALS['xoopsUser']->getVar('url')));
                $key->setVar('key', authkey_getAuthKey());
                $key->setVar('uid', $GLOBALS['xoopsUser']->getVar('uid'));
                xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->insert($key, true);
            }
        }
    }

    
    /**
     * @param $args
     */
    public static function eventCoreFooterEnd($args)
    {
        xoops_loadLanguage('modinfo', basename(dirname(__DIR__)));
        
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'header.php';
        
        xoops_load('XoopsCache');
        if (!$rrt = XoopsCache::read('auto-generate') && $GLOBALS['authkeyConfigsList']['auto-generate'] == true)
        {
            $criteria = new CriteriaCompo(new Criteria('uid', '(' . implode(', ', xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->getUIDs()) . ')', 'NOT IN'));
            $criteria->add(new Criteria('level', '1', '>='));
            $criteria->setLimit($GLOBALS['authkeyConfigsList']['number-auto-generated']);
            $criteria->setOrder("RAND()");
            foreach(xoops_getHandler('members')->getUsers($criteria, true) as $user)
            {
                $key = xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->create();
                $key->setVar('email', $user->getVar('email'));
                $key->setVar('title', sprintf(_MI_AUTHKEY_KEY_TITLE, $user->getVar('uname')));
                $key->setVar('name', (strlen($user->getVar('name'))==0?$user->getVar('uname'):$user->getVar('name')));
                $key->setVar('company', $GLOBALS['xoopsConfig']['sitename']);
                $key->setVar('url', (strlen($user->getVar('url'))==0?XOOPS_URL:$user->getVar('url')));
                $key->setVar('key', authkey_getAuthKey());
                $key->setVar('uid', $user->getVar('uid'));
                xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->insert($key, true);
            }
            XoopsCache::write('auto-generate', array("time"=>time()), $GLOBALS['authkeyConfigsList']['auto-generate-seconds']);
        }
    }
}
