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

global $authkeyModule, $op, $mode;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'header.php';

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

$return = array();
switch ($inner['mode'])
{
    default:
        $help = true;
        break;
    case "getkey":
        $usersHandler = xoops_getHandler('users');
        
        $criteriap = new CriteriaCompo(new Criteria('pass', $inner['pass']));
        $criteriap->add(new Criteria('pass', md5($inner['pass'])), 'OR');
        $criteria = new CriteriaCompo(new Criteria('uname', $inner['uname']));
        $criteria->add($criteriap);
        
        if ($userObjs = $usersHandler->getObjects($criteria) && !empty($userObjs[0]))
        {
            $keysHandler = xoops_getModuleHandler('keys', basename(dirname(__DIR__)));
            $criteria = new Criteria('uid', $userObjs[0]->getVar('uid'));
            if ($keysHandler->getCount($criteria) >= 1)
                if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWCREATING, false, $userObjs[0]->getVar('uid')))
                {
                    $keys = $keysHandler->getObjects($criteria);
                    if (!empty($keys[0]))
                        $return = array('code' => 201, 'xoopskey' => $keys[0]->getVar('key'), 'issuing' => $keys[0]->getVar('issuing'));
                }
                
            if (empty($return) && !strlen($inner['title']))
                $return = array('code' => 501, 'errors' => array(102 => 'Variable required to be passed the title of the key in "title" ~ field element not found!'));
            elseif (empty($return) && !strlen($inner['name']))
                $return = array('code' => 501, 'errors' => array(103 => 'Variable required to be passed the individual name of the owner of the key in "name" ~ field element not found!'));
            elseif (empty($return) && !strlen($inner['url']))
                $return = array('code' => 501, 'errors' => array(105 => 'Variable required to be passed the url of the owning site of the key in "url" ~ field element not found!'));
            elseif (empty($return) && !strlen($inner['email']))
                $return = array('code' => 501, 'errors' => array(106 => 'Variable required to be passed the owning sites email of the key in "email" ~ field element not found!'));
            elseif (empty($return) && checkEmail($inner['email']))
                $return = array('code' => 501, 'errors' => array(107 => 'Variable required to be passed not a valid owning sites email in the field element "email" ~ field element invalid!'));
                
            if (empty($return)) {
                
                $object = $keysHandler->create();
                $object->setVar('title', $inner['title']);
                $object->setVar('name', $inner['name']);
                $object->setVar('company', $inner['company']);
                $object->setVar('url', $inner['url']);
                $object->setVar('email', $inner['email']);
                $object->setVar('uid', $userObjs[0]->getVar('uid'));
                
                $key = $keysHandler->get($keysHandler->insert($object, true));
                $return = array('code' => 201, 'xoopskey' => $key->getVar('key'), 'issuing' => $key->getVar('issuing'));
            }
            
        } else {
            $return = array('code' => 501, 'errors' => array(101 => 'Username of "' . $inner['uname'] . '" with the password of "' . $inner['pass'] . '" not found!'));
        }
        break;
    case "verify":
        if (!strlen($inner['xoopskey']))
            $return = array('code' => 501, 'errors' => array(108 => 'Variable required to be passed the authkey/xoopskey in the field element: "xoopskey" ~ field element not found!'));
        if (!strlen($inner['api-url']))
            $return = array('code' => 501, 'errors' => array(113 => 'Variable required to be passed with the api in the field element: "api-url" ~ field element not found!'));
        
        if (empty($return)) {
            $apisHandler = xoops_getModuleHandler('apis', basename(dirname(__DIR__)));
            $criteria = new CriteriaCompo(new Criteria('`api-http`', $GLOBALS['xoopsDB']->escape($inner['api-url']), 'LIKE'));
            $criteria->add(new Criteria('`api-https`', $GLOBALS['xoopsDB']->escape($inner['api-url']), 'LIKE'), 'OR');
            if ($apisHandler->getCount($criteria)==0)
                $return = array('code' => 501, 'errors' => array(114 => 'Variable passed but not found on the with the api in the field element: "api-url" ~ "'.$inner['api-url'].'" not found on resource!'));
            else {
                $apis = $apisHandler->getObjects($criteria);
                if (!empty($apis[0]))
                {
                    $api = $apis[0];
                    unset($apis);
                }
            }
            $keysHandler = xoops_getModuleHandler('keys', basename(dirname(__DIR__)));
            if (!$token = XoopsCache::read("xoopskey_".md5($inner['xoopskey'])) && empty($return))
            {
                if (!$key = $keysHandler->getByXoopsKey($inner['xoopskey']))
                    $return = array('code' => 501, 'errors' => array(109 => 'Variable not found in database being passed as the xoopskey in the field element: "key" ~ field element data not found!'));
                if (is_object($key) && empty($return))
                {
                    
                    if ($api->getVar('stats-hour') < time())
                        $api->setVar('stats-hour', time() + (3600));
                    if ($api->getVar('stats-day') < time())
                        $api->setVar('stats-day', time() + (3600 * 24));
                    if ($api->getVar('stats-week') < time())
                        $api->setVar('stats-week', time() + (3600 * 24 * 7));
                    if ($api->getVar('stats-month') < time())
                        $api->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
                    if ($api->getVar('stats-quarter') < time())
                        $api->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
                    if ($api->getVar('stats-year') < time())
                        $api->setVar('stats-year', time() + (3600 * 24 * 7 * 4 * 12));
                        
                    if ($key->getVar('stats-hour') < time())
                        $key->setVar('stats-hour', time() + (3600));
                    if ($key->getVar('stats-day') < time())
                        $key->setVar('stats-day', time() + (3600 * 24));
                    if ($key->getVar('stats-week') < time())
                        $key->setVar('stats-week', time() + (3600 * 24 * 7));
                    if ($key->getVar('stats-month') < time())
                        $key->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
                    if ($key->getVar('stats-quarter') < time())
                        $key->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
                    if ($key->getVar('stats-year') < time())
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
                    
                    @xoops_getModuleHandler('users', basename(dirname(__DIR__)))->insert($user, true);
                    $key = $keysHandler->get($keyid = $keysHandler->insert($key, true));
                    $data = $key->getValues(array_keys($key->vars));
                    $token[$api->getVar('api-type')][$inner['api-url']] = 1;
                    $data['polling'] = 1;
                    $data['polled'] = time();
                    XoopsCache::write("xoopskey_".md5($key->getVar('key')), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(md5($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(sha1($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                    $return = array('code'=>201, 'passed' => true);
                }
            } else {
                if (isset($token[$api->getVar('api-type')][$inner['api-url']]))
                    $token[$api->getVar('api-type')][$inner['api-url']] = $token[$api->getVar('api-type')][$inner['api-url']] + 1;
                else 
                    $token[$api->getVar('api-type')][$inner['api-url']] = 1;
                $token['polling'] = $token['polling'] + 1;
                $token['polled-last'] = $token['polled'];
                $token['polled'] = time() + $GLOBALS['authkeyConfigsList']['polling-seconds'];
                XoopsCache::write("xoopskey_".md5($inner['xoopskey']), $token, 3600 * 24 * 7 * 4 * 36);
               
                $key = $keysHandler->get($token['id']);
                $return = array('code'=>201, 'passed' => true, 'user-hash' => md5($key->getVar('uid').XOOPS_URL.XOOPS_DB_PASS), 'key-hash' => md5($key->getVar('id').XOOPS_URL.XOOPS_DB_PASS));
                
                foreach(array(md5($key->getVar('key')), md5(md5($key->getVar('key'))), md5(sha1($key->getVar('key')))) as $keyy) {
                    if ($token = XoopsCache::read("xoopskey_".$keyy)) {
                        if ($token['polled-last'] < time() || $key->getVar('stats-hour') < time() || $key->getVar('stats-day') < time() || $key->getVar('stats-week') < time() || $key->getVar('stats-month') < time() || $key->getVar('stats-quarter') < time() || $key->getVar('stats-year') < time())
                        {
                            
                            $api->setVar('calls-hour', $api->getVar('calls-hour') + $token[$api->getVar('api-type')][$inner['api-url']]);
                            $api->setVar('calls-day', $api->getVar('calls-day') + $token[$api->getVar('api-type')][$inner['api-url']]);
                            $api->setVar('calls-week', $api->getVar('calls-week') + $token[$api->getVar('api-type')][$inner['api-url']]);
                            $api->setVar('calls-month', $api->getVar('calls-month') + $token[$api->getVar('api-type')][$inner['api-url']]);
                            $api->setVar('calls-quarter', $api->getVar('calls-quarter') + $token[$api->getVar('api-type')][$inner['api-url']]);
                            $api->setVar('calls-year', $api->getVar('calls-year') + $token[$api->getVar('api-type')][$inner['api-url']]);
                            $token[$api->getVar('api-type')][$inner['api-url']] = 0;
                            
                            $key = $keysHandler->get($token['id']);
                            $key->setVar('calls-hour', $key->getVar('calls-hour') + $token['polling']);
                            $key->setVar('calls-day', $key->getVar('calls-day') + $token['polling']);
                            $key->setVar('calls-week', $key->getVar('calls-week') + $token['polling']);
                            $key->setVar('calls-month', $key->getVar('calls-month') + $token['polling']);
                            $key->setVar('calls-quarter', $key->getVar('calls-quarter') + $token['polling']);
                            $key->setVar('calls-year', $key->getVar('calls-year') + $token['polling']);
                            
                            $user = xoops_getModuleHandler('users', basename(dirname(__DIR__)))->get($key->getVar('uid'));
                            $user->setVar('calls-hour', $user->getVar('calls-hour') + $token['polling']);
                            $user->setVar('calls-day', $user->getVar('calls-day') + $token['polling']);
                            $user->setVar('calls-week', $user->getVar('calls-week') + $token['polling']);
                            $user->setVar('calls-month', $user->getVar('calls-month') + $token['polling']);
                            $user->setVar('calls-quarter', $user->getVar('calls-quarter') + $token['polling']);
                            $user->setVar('calls-year', $user->getVar('calls-year') + $token['polling']);
                            $token['polling'] = 0;
                            
                            $overlimit = false;
                            if ($GLOBALS['authkeyConfigsList']['limited']==true)
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
                                
                            $key = $keysHandler->get($keyid = $keysHandler->insert($key, true));
                            XoopsCache::write("xoopskey_".$keyy, $token, 3600 * 24 * 7 * 4 * 36);
                        }
                    }
                }
                    
                if ($key->getVar('stats-hour') < time() || $key->getVar('stats-day') < time() || $key->getVar('stats-week') < time() || $key->getVar('stats-month') < time() || $key->getVar('stats-quarter') < time() || $key->getVar('stats-year') < time())
                {
                    if ($api->getVar('stats-hour') < time())
                        $api->setVar('stats-hour', time() + (3600));
                    if ($api->getVar('stats-day') < time())
                        $api->setVar('stats-day', time() + (3600 * 24));
                    if ($api->getVar('stats-week') < time())
                        $api->setVar('stats-week', time() + (3600 * 24 * 7));
                    if ($api->getVar('stats-month') < time())
                        $api->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
                    if ($api->getVar('stats-quarter') < time())
                        $api->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
                    if ($api->getVar('stats-year') < time())
                        $api->setVar('stats-year', time() + (3600 * 24 * 7 * 4 * 12));
                        
                    if ($key->getVar('stats-hour') < time())
                        $key->setVar('stats-hour', time() + (3600));
                    if ($key->getVar('stats-day') < time())
                        $key->setVar('stats-day', time() + (3600 * 24));
                    if ($key->getVar('stats-week') < time())
                        $key->setVar('stats-week', time() + (3600 * 24 * 7));
                    if ($key->getVar('stats-month') < time())
                        $key->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
                    if ($key->getVar('stats-quarter') < time())
                        $key->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
                    if ($key->getVar('stats-year') < time())
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
                    
                    @xoops_getModuleHandler('users', basename(dirname(__DIR__)))->insert($user, true);
                    
                    $key = $keysHandler->get($keyid = $keysHandler->insert($key, true));
                    $data = $key->getValues(array_keys($key->vars));
                    $data[$api->getVar('api-type')][$inner['api-url']] = 0;
                    $data['polling'] = 0;
                    $data['polled'] = time() + $GLOBALS['authkeyConfigsList']['polling-seconds'];
                    XoopsCache::write("xoopskey_".md5($key->getVar('key')), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(md5($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(sha1($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                }
                @$apisHandler->insert($api, true);
                if ($GLOBALS['authkeyConfigsList']['limited'] == true && $overlimit == true && !authkeys_checkperm(_MI_AUTHKEY_PERM_UNLIMITEDCALLS, $key->getVar('id'), $key->getVar('uid')) == false) 
                    $return = array('code'=>501, 'passed' => false, 'errors' => array(110 => 'Over Limit of Calling Polls to API\'s'));                    
            }
        }
        break;
}

/**
 * Buffers Help
 */
if ($help==true) {
    if (function_exists("http_response_code"))
        http_response_code(400);
    include __DIR__ . DS . 'help.php';
    exit;
}

/**
 * Commences Execution of API Functions
 */
if (function_exists("http_response_code"))
    http_response_code((isset($return['code'])?$return['code']:200));
if (isset($return['code']))
    unset($return['code']);
        
switch ($inner['format']) {
    case 'html':
        echo '<pre style="font-family: \'Courier New\', Courier, Terminal; font-size: 0.77em;">';
        echo var_dump($return, true);
        echo '</pre>';
        break;
    case 'raw':
        echo "<?php\n\n return " . var_export($return, true) . ";\n\n?>";
        break;
    default:
    case 'json':
        header('Content-type: application/json');
        echo json_encode($return);
        break;
    case 'serial':
        header('Content-type: text/html');
        echo serialize($return);
        break;
    case 'xml':
        header('Content-type: application/xml');
        $dom = new XmlDomConstruct('1.0', 'utf-8');
        $dom->fromMixed(array('root'=>$return));
        echo $dom->saveXML();
        break;
}

exit(0);
