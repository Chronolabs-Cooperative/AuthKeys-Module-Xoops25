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
        
        if ($userObjs = $usersHandler->getObjects($criteria) && isset($userObjs[0]))
        {
            if (!strlen($inner['title']))
                $return = array('code' => 501, 'errors' => array(102 => 'Variable required to be passed the title of the key in "title" ~ field element not found!'));
            elseif (!strlen($inner['name']))
                $return = array('code' => 501, 'errors' => array(103 => 'Variable required to be passed the individual name of the owner of the key in "name" ~ field element not found!'));
            elseif (!strlen($inner['url']))
                $return = array('code' => 501, 'errors' => array(105 => 'Variable required to be passed the url of the owning site of the key in "url" ~ field element not found!'));
            elseif (!strlen($inner['email']))
                $return = array('code' => 501, 'errors' => array(106 => 'Variable required to be passed the owning sites email of the key in "email" ~ field element not found!'));
            elseif (checkEmail($inner['email']))
                $return = array('code' => 501, 'errors' => array(107 => 'Variable required to be passed not a valid owning sites email in the field element "email" ~ field element invalid!'));
                
            if (empty($return)) {
                $keysHandler = xoops_getModuleHandler('keys', basename(dirname(__DIR__)));
                
                $object = $keysHandler->create();
                $object->setVar('title', $inner['title']);
                $object->setVar('name', $inner['name']);
                $object->setVar('company', $inner['company']);
                $object->setVar('url', $inner['url']);
                $object->setVar('email', $inner['email']);
                $object->setVar('uid', $userObjs[0]->getVar('uid'));
                
                $key = $keysHandler->get($keysHandler->insert($object, true));
                $return = array('code' => 201, 'authkey' => $key->getVar('key'), 'issuing' => $key->getVar('issuing'));
            }
            
        } else {
            $return = array('code' => 501, 'errors' => array(101 => 'Username of "' . $inner['uname'] . '" with the password of "' . $inner['pass'] . '" not found!'));
        }
        break;
    case "verify":
        if (!strlen($inner['key']))
            $return = array('code' => 501, 'errors' => array(108 => 'Variable required to be passed the the xoopskey in the field element: "key" ~ field element not found!'));
        if (empty($return)) {
            $keysHandler = xoops_getModuleHandler('keys', basename(dirname(__DIR__)));
            if (!$token = XoopsCache::read("xoopskey_".md5($inner['key'])))
            {
                if (!$key = $keysHandler->getByXoopsKey($inner['key']))
                    $return = array('code' => 501, 'errors' => array(109 => 'Variable not found in database being passed as the xoopskey in the field element: "key" ~ field element data not found!'));
                if (is_object($key) && empty($return))
                {
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
                    
                    $key = $keysHandler->get($keyid = $keysHandler->insert($key, true));
                    $data = $key->getValues(array_keys($key->vars));
                    $data['polling'] = 0;
                    $data['polled'] = time();
                    XoopsCache::write("xoopskey_".md5($key->getVar('key')), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(md5($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(sha1($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                    $return = array('code'=>201, 'passed' => true);
                }
            } else {
                $token['polling'] = $token['polling'] + 1;
                $token['polled'] = time();
                XoopsCache::write("xoopskey_".md5($inner['key']), $token, 3600 * 24 * 7 * 4 * 36);
               
                $key = $keysHandler->get($token['id']);
                $return = array('code'=>201, 'passed' => true, 'user-id' => $key->getVar('uid'), 'key-id' => md5($key->getVar('id').XOOPS_URL.XOOPS_DB_PASS));
                
                foreach(array(md5($key->getVar('key')), md5(md5($key->getVar('key'))), md5(sha1($key->getVar('key')))) as $keyy) {
                    if ($token = XoopsCache::read("xoopskey_".$keyy)) {
                        if ($token['polled'] < time() - $authkeyConfigsList['polling-seconds'] || $key->getVar('stats-hour') < time() || $key->getVar('stats-day') < time() || $key->getVar('stats-week') < time() || $key->getVar('stats-month') < time() || $key->getVar('stats-quarter') < time() || $key->getVar('stats-year') < time())
                        {
                            $key = $keysHandler->get($token['id']);
                            $key->setVar('calls-hour', $key->getVar('calls-hour') + $token['polling']);
                            $key->setVar('calls-day', $key->getVar('calls-day') + $token['polling']);
                            $key->setVar('calls-week', $key->getVar('calls-week') + $token['polling']);
                            $key->setVar('calls-month', $key->getVar('calls-month') + $token['polling']);
                            $key->setVar('calls-quarter', $key->getVar('calls-quarter') + $token['polling']);
                            $key->setVar('calls-year', $key->getVar('calls-year') + $token['polling']);
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
                            }
                                
                            $key = $keysHandler->get($keyid = $keysHandler->insert($key, true));
                            XoopsCache::write("xoopskey_".$keyy, $token, 3600 * 24 * 7 * 4 * 36);
                        }
                    }
                }
                    
                if ($key->getVar('stats-hour') < time() || $key->getVar('stats-day') < time() || $key->getVar('stats-week') < time() || $key->getVar('stats-month') < time() || $key->getVar('stats-quarter') < time() || $key->getVar('stats-year') < time())
                {
                    
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
                
                    $key = $keysHandler->get($keyid = $keysHandler->insert($key, true));
                    $data = $key->getValues(array_keys($key->vars));
                    $data['polling'] = 0;
                    $data['polled'] = time();
                    XoopsCache::write("xoopskey_".md5($key->getVar('key')), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(md5($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                    XoopsCache::write("xoopskey_".md5(sha1($key->getVar('key'))), $data, 3600 * 24 * 7 * 4 * 36);
                }
                
                if ($authkeyConfigsList['limited']==true && $overlimit == true) {
                    
                    $return = array('code'=>501, 'passed' => false, 'error' => array(110 => 'Over Limit of Calling Polls to API\'s'));
                }
                    
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
