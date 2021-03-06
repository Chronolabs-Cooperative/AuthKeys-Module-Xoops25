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
class AuthkeyPollingPreload extends XoopsPreloadItem
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
        
        if (!$rtt = XoopsCache::read('authkey_polling'))
        {
            $criteria = new CriteriaCompo(new Criteria('`stats-hour`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-day`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-week`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-month`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-quarter`', time(), "<="), 'OR');
            $criteria->add(new Criteria('`stats-year`', time(), "<="), 'OR');
            foreach(xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->getObjects($criteria) as $key)
            {
                if ($key->getVar('stats-hour') <= time())
                    $key->setVar('stats-hour', time() + (3600));
                if ($key->getVar('stats-day') <= time())
                    $key->setVar('stats-day', time() + (3600 * 24));
                if ($key->getVar('stats-week') <= time())
                    $key->setVar('stats-week', time() + (3600 * 24 * 7));
                if ($key->getVar('stats-month') <= time())
                    $key->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
                if ($key->getVar('stats-quarter') <= time())
                    $key->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
                if ($key->getVar('stats-year') <= time())
                    $key->setVar('stats-year', time() + (3600 * 24 * 7 * 4 * 12));
                
                $user = xoops_getModuleHandler('users', basename(dirname(__DIR__)))->get($key->getVar('uid'));
                if ($user->getVar('stats-hour') <= time())
                    $user->setVar('stats-hour', time() + (3600));
                if ($user->getVar('stats-day') <= time())
                    $user->setVar('stats-day', time() + (3600 * 24));
                if ($user->getVar('stats-week') <= time())
                    $user->setVar('stats-week', time() + (3600 * 24 * 7));
                if ($user->getVar('stats-month') <= time())
                    $user->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
                if ($user->getVar('stats-quarter') <= time())
                    $user->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
                if ($user->getVar('stats-year') <= time())
                    $user->setVar('stats-year', time() + (3600 * 24 * 7 * 4 * 12));
                
                foreach(array(md5($key->getVar('key')), md5(md5($key->getVar('key'))), md5(sha1($key->getVar('key')))) as $keyy) {
                    if ($token = XoopsCache::read("xoopskey_".$keyy)) {   
                        
                        foreach(xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->getURLSArray() as $apitype => $urls)
                            foreach($urls as $apiurl => $apiname)
                                if (isset($token[$apitype][$apiurl]) && !empty($token[$apitype][$apiurl]))
                                {
                                    $criteria = new CriteriaCompo(new Criteria('`api-http`', $apiurl, 'LIKE'));
                                    $criteria->add(new Criteria('`api-https`', $apiurl, 'LIKE'), 'OR');
                                    $criteria->add(new Criteria('`api-type`', $apitype, 'LIKE'), 'AND');
                                    $apis = xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->getObjects($criteria);
                                    if (!empty($apis[0]))
                                    {
                                        $apis[0]->setVar('calls-hour', $apis[0]->getVar('calls-hour') + $token[$apitype][$apiurl]);
                                        $apis[0]->setVar('calls-day', $apis[0]->getVar('calls-day') + $token[$apitype][$apiurl]);
                                        $apis[0]->setVar('calls-week', $apis[0]->getVar('calls-week') + $token[$apitype][$apiurl]);
                                        $apis[0]->setVar('calls-month', $apis[0]->getVar('calls-month') + $token[$apitype][$apiurl]);
                                        $apis[0]->setVar('calls-quarter', $apis[0]->getVar('calls-quarter') + $token[$apitype][$apiurl]);
                                        $apis[0]->setVar('calls-year', $apis[0]->getVar('calls-year') + $token[$apitype][$apiurl]);
                                        if (xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->insert($apis[0], true))
                                            $token[$apitype][$apiurl] = 0;
                                    }
                                }
                        
                        $key->setVar('calls-hour', $key->getVar('calls-hour') + $token['polling']);
                        $key->setVar('calls-day', $key->getVar('calls-day') + $token['polling']);
                        $key->setVar('calls-week', $key->getVar('calls-week') + $token['polling']);
                        $key->setVar('calls-month', $key->getVar('calls-month') + $token['polling']);
                        $key->setVar('calls-quarter', $key->getVar('calls-quarter') + $token['polling']);
                        $key->setVar('calls-year', $key->getVar('calls-year') + $token['polling']);
                        
                        $user->setVar('calls-hour', $user->getVar('calls-hour') + $token['polling']);
                        $user->setVar('calls-day', $user->getVar('calls-day') + $token['polling']);
                        $user->setVar('calls-week', $user->getVar('calls-week') + $token['polling']);
                        $user->setVar('calls-month', $user->getVar('calls-month') + $token['polling']);
                        $user->setVar('calls-quarter', $user->getVar('calls-quarter') + $token['polling']);
                        $user->setVar('calls-year', $user->getVar('calls-year') + $token['polling']);
                        
                        $token['polling'] = 0;
                        
                        $overlimit = false;
                        if ($authkeyConfigsList['limited']==true)
                        {
                            if ($key->getVar('limit-hour') < $key->getVar('calls-hour'))
                            {
                                $overlimit = true;
                                $key->setVar('overs-hour', $key->getVar('calls-hour') - $key->getVar('limit-hour'));
                            }
                            if ($key->getVar('limit-day') < $key->getVar('calls-day'))
                            {
                                $overlimit = true;
                                $key->setVar('overs-day', $key->getVar('calls-day') - $key->getVar('limit-day'));
                            }
                            if ($key->getVar('limit-week') < $key->getVar('calls-week'))
                            {
                                $overlimit = true;
                                $key->setVar('overs-week', $key->getVar('calls-week') - $key->getVar('limit-week'));
                            }
                            if ($key->getVar('limit-month') < $key->getVar('calls-month'))
                            {
                                $overlimit = true;
                                $key->setVar('overs-month', $key->getVar('calls-month') - $key->getVar('limit-month'));
                            }
                            if ($key->getVar('limit-quarter') < $key->getVar('calls-quarter'))
                            {
                                $overlimit = true;
                                $key->setVar('overs-quarter', $key->getVar('calls-quarter') - $key->getVar('limit-quarter'));
                            }
                            if ($key->getVar('limit-year') < $key->getVar('calls-year'))
                            {
                                $overlimit = true;
                                $key->setVar('overs-year', $key->getVar('calls-year') - $key->getVar('limit-year'));
                            }
                            if ($user->getVar('limit-hour') < $user->getVar('calls-hour'))
                            {
                                $overlimit = true;
                                $user->setVar('overs-hour', $user->getVar('calls-hour') - $user->getVar('limit-hour'));
                            }
                            if ($user->getVar('limit-day') < $user->getVar('calls-day'))
                            {
                                $overlimit = true;
                                $user->setVar('overs-day', $user->getVar('calls-day') - $user->getVar('limit-day'));
                            }
                            if ($user->getVar('limit-week') < $user->getVar('calls-week'))
                            {
                                $overlimit = true;
                                $user->setVar('overs-week', $user->getVar('calls-week') - $user->getVar('limit-week'));
                            }
                            if ($user->getVar('limit-month') < $user->getVar('calls-month'))
                            {
                                $overlimit = true;
                                $user->setVar('overs-month', $user->getVar('calls-month') - $user->getVar('limit-month'));
                            }
                            if ($user->getVar('limit-quarter') < $user->getVar('calls-quarter'))
                            {
                                $overlimit = true;
                                $user->setVar('overs-quarter', $user->getVar('calls-quarter') - $user->getVar('limit-quarter'));
                            }
                            if ($user->getVar('limit-year') < $user->getVar('calls-year'))
                            {
                                $overlimit = true;
                                $user->setVar('overs-year', $user->getVar('calls-year') - $user->getVar('limit-year'));
                            }
                        }
    
                        XoopsCache::write("xoopskey_".$keyy, $token, 3600 * 24 * 7 * 4 * 36);
                    }
                }
                @xoops_getModuleHandler('users', basename(dirname(__DIR__)))->insert($user, true);
                @xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->insert($key, true);
            }
            XoopsCache::write('authkey_polling', array('time'=>time()), $authkeyConfigsList['preload-seconds']);
        }
    }
}
