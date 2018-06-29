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
class AuthkeyCheckingPreload extends XoopsPreloadItem
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
        
        if (!$rtt = XoopsCache::read('authkey_checking'))
        {
            $criteria = new CriteriaCompo(new Criteria('`checking`', time(), "<="));
            foreach(xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->getObjects($criteria) as $api)
            {
                $status = $api->getVar('status');
                $json = json_decode(getURLData($api->getVar('api-https') . '/' . $api->getVar('api-version') . '/test.api', 30, 30));
                if (isset($json['api-type']) && !empty($json['api-type']) && $json['api-type'] == $api->getVar('api-type'))
                {
                    $api->setVar('mode', 'https');
                    $api->setVar('status', 'online');
                    if ($status == 'offline')
                        $api->setVar('online', 0);
                    else 
                        $api->setVar('online', $api->getVar('online') + $api->getVar('checking') - $api->getVar('checked'));
                    $api->setVar('checked', $api->getVar('checking'));
                    $api->setVar('checking', time() + (3600 * mt_rand(8, 24)));
                    @xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->insert($api, true);
                } else {
                    $json = json_decode(getURLData($api->getVar('api-http') . '/' . $api->getVar('api-version') . '/test.api', 30, 30));
                    if (isset($json['api-type']) && !empty($json['api-type']) && $json['api-type'] == $api->getVar('api-type'))
                    {
                        $api->setVar('mode', 'http');
                        $api->setVar('status', 'online');
                        if ($status == 'offline')
                            $api->setVar('online', 0);
                        else
                            $api->setVar('online', $api->getVar('online') + $api->getVar('checking') - $api->getVar('checked'));
                        $api->setVar('checked', $api->getVar('checking'));
                        $api->setVar('checking', time() + (3600 * mt_rand(8, 24)));
                        @xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->insert($api, true);
                    } else {
                        $api->setVar('mode', 'http');
                        $api->setVar('status', 'offline');
                        if ($status == 'online')
                            $api->setVar('offline', 0);
                        else
                            $api->setVar('offline', $api->getVar('offline') + $api->getVar('checking') - $api->getVar('checked'));
                        $api->setVar('checked', $api->getVar('checking'));
                        $api->setVar('checking', time() + (3600 * mt_rand(2, 7)));
                        @xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->insert($api, true);
                    }
                }
            }
            XoopsCache::write('authkey_checking', array('time'=>time()), $authkeyConfigsList['preload-seconds']);
        }
    }
}
