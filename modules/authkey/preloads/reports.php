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
class AuthkeyReportsPreload extends XoopsPreloadItem
{
    
    /**
     * @param $args
     */
    public static function eventCoreIncludeCommonEnd($args)
    {
        xoops_loadLanguage('modinfo', basename(dirname(__DIR__)));
        xoops_load('XoopsCache');
        
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'header.php';
        
        if (!$rtt = XoopsCache::read('authkey_reporting'))
        {
            $criteria = new CriteriaCompo(new Criteria('`stats-hour`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-day`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-week`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-month`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-quarter`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-year`', time(), "<="), 'OR');
            foreach(xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->getObjects($criteria) as $key)
            {
            }
            XoopsCache::write('authkey_reporting', array('time'=>time()), $authkeyConfigsList['preload-seconds']);
        }
        
    }
}
