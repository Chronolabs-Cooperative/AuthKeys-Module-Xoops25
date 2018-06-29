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


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'xcp' . DIRECTORY_SEPARATOR . 'xcp.class.php';


if (!function_exists("authkey_getTimePeriod")) {
    
    /* function eightbit_loadConfig()
     *
     * Converts Seconds to Staggered United Display
     *
     * @author 		Simon Roberts (Chronolabs) simon@labs.coop
     *
     * @return 		array()
     */
    function authkey_getTimePeriod($seconds = 0)
    {
        $result = array();
        $months = 3600 * 24 * 7 * 4;
        $weeks = 3600 * 24 * 7;
        $days = 3600 * 24;
        $hours = 3600;
        $minutes = 3600 / 60;
        $seconds = 60;
        if (floor($seconds / $months) != 0) {
            $result[] = floor($seconds / $months) . 'mth';
            $seconds = $seconds - (floor($seconds / $months) * $months);
        }
        if (floor($seconds / $weeks) != 0) {
            $result[] = floor($seconds / $weeks) . 'wk';
            $seconds = $seconds - (floor($seconds / $weeks) * $weeks);
        }
        if (floor($seconds / $days) != 0) {
            $result[] = floor($seconds / $days) . 'd';
            $seconds = $seconds - (floor($seconds / $days) * $days);
        }
        if (floor($seconds / $hours) != 0) {
            $result[] = floor($seconds / $hours) . 'h';
            $seconds = $seconds - (floor($seconds / $hours) * $hours);
        }
        if (floor($seconds / $minutes) != 0) {
            $result[] = floor($seconds / $minutes) . 'm';
            $seconds = $seconds - (floor($seconds / $minutes) * $minutes);
        }
        if (floor($seconds) != 0) {
            $result[] = floor($seconds) . 's';
            $seconds = $seconds - (floor($seconds));
        }
        return implode(" ", $result);
    }
}

function getHTMLForm($mode = '')
{
    
    
    $form = array();
    switch ($mode)
    {
        case "getkey":
            $form[] = "<form name='auth-key' method=\"POST\" enctype=\"multipart/form-data\" action=\"" . ($authkeyConfigsList['htaccess'] == true ? XOOPS_URL . '/' . $authkeyConfigsList['baseurl'] . '/getkey.api' : XOOPS_URL . '/modules/' . basename(dirname(__DIR__)) . '/api/?mode=getkey') . '">';
            $form[] = "\t<table class='auth-key' id='auth-key' style='vertical-align: top !important; min-width: 98%;'>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='uname'>Username for xoops.org:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='uname' id='uname' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='pass'>Password or md5(Password) for xoops.org:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='pass' name='pass' id='pass' size='41' /><br/>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='title'>Title for Key (a Name for it):&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='title' id='title' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='name'>Individual name key is for:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='name' id='name' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='company'>Company name key is for:&nbsp;</label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='company' id='company' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='url'>URL Key is for:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='url' id='url' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='email'>Individual/Owner of Key Email for Notices:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='email' id='email' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<label for='format'>Output Format:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<select name='format' id='format'/>";
            $form[] = "\t\t\t\t\t<option value='raw'>RAW PHP Output</option>";
            $form[] = "\t\t\t\t\t<option value='json' selected='selected'>JSON Output</option>";
            $form[] = "\t\t\t\t\t<option value='serial'>Serialisation Output</option>";
            $form[] = "\t\t\t\t\t<option value='xml'>XML Output</option>";
            $form[] = "\t\t\t\t</select>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td colspan='3' style='padding-left:64px;'>";
            $form[] = "\t\t\t\t<input type='hidden' value='getkey' name='mode'>";
            $form[] = "\t\t\t\t<input type='submit' value='Generate and Store a XOOPS Auth Key' name='submit' style='padding:11px; font-size:122%;'>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td colspan='3' style='padding-top: 8px; padding-bottom: 14px; padding-right:35px; text-align: right;'>";
            $form[] = "\t\t\t\t<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold;'>* </font><font  style='color: rgb(10,10,10); font-size: 99%; font-weight: bold'><em style='font-size: 76%'>~ Required Field for Form Submission</em></font>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t</table>";
            $form[] = "</form>";
            break;
    
        case "verify":
            $form[] = "<form name='new-domain' method=\"POST\" enctype=\"multipart/form-data\" action=\"" . ($authkeyConfigsList['htaccess'] == true ? XOOPS_URL . '/' . $authkeyConfigsList['baseurl'] . '/verify.api' : XOOPS_URL . '/modules/' . basename(dirname(__DIR__)) . '/api/?mode=verify') . '">';
            $form[] = "\t<table class='new-domain' id='auth-domain' style='vertical-align: top !important; min-width: 98%;'>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='xoopskey'>Xoops Auth Key:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='xoopskey' id='xoopskey' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<label for='format'>Output Format:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<select name='format' id='format'/>";
            $form[] = "\t\t\t\t\t<option value='raw'>RAW PHP Output</option>";
            $form[] = "\t\t\t\t\t<option value='json' selected='selected'>JSON Output</option>";
            $form[] = "\t\t\t\t\t<option value='serial'>Serialisation Output</option>";
            $form[] = "\t\t\t\t\t<option value='xml'>XML Output</option>";
            $form[] = "\t\t\t\t</select>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td colspan='3' style='padding-left:64px;'>";
            $form[] = "\t\t\t\t<input type='hidden' value='verify' name='mode'>";
            $form[] = "\t\t\t\t<input type='submit' value='Verify and Count Polling of XOOPS Auth-Key' name='submit' style='padding:11px; font-size:122%;'>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td colspan='3' style='padding-top: 8px; padding-bottom: 14px; padding-right:35px; text-align: right;'>";
            $form[] = "\t\t\t\t<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold;'>* </font><font  style='color: rgb(10,10,10); font-size: 99%; font-weight: bold'><em style='font-size: 76%'>~ Required Field for Form Submission</em></font>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t</table>";
            $form[] = "</form>";
            break;
            
        case "newkey":
            
            $form[] = "<form name='new-key' method=\"POST\" enctype=\"multipart/form-data\" action=\"" . ($authkeyConfigsList['htaccess'] == true ? XOOPS_URL . '/' . $authkeyConfigsList['baseurl'] . '/post.api?mode=newkey' : XOOPS_URL . '/modules/' . basename(dirname(__DIR__)) . '/post.php?mode=newkey') . '">';
            $form[] = "\t<table class='new-key' id='new-key' style='vertical-align: top !important; min-width: 98%;'>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='title'>Title for Key (a Name for it):&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='title' id='title' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='name'>Individual name key is for:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='name' id='name' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='company'>Company name key is for:&nbsp;</label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='company' id='company' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='url'>URL Key is for:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='url' id='url' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td style='width: 320px;'>";
            $form[] = "\t\t\t\t<label for='email'>Individual/Owner of Key Email for Notices:&nbsp;<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold'>*</font></label>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>";
            $form[] = "\t\t\t\t<input type='textbox' name='email' id='email' size='41' />&nbsp;&nbsp;";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t\t<td>&nbsp;</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td colspan='3' style='padding-left:64px;'>";
            $form[] = "\t\t\t\t<input type='hidden' value='newkey' name='mode'>";
            $form[] = "\t\t\t\t<input type='submit' value='Generate New XOOPS Auth Key' name='submit' style='padding:11px; font-size:122%;'>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t\t\t<td colspan='3' style='padding-top: 8px; padding-bottom: 14px; padding-right:35px; text-align: right;'>";
            $form[] = "\t\t\t\t<font style='color: rgb(250,0,0); font-size: 139%; font-weight: bold;'>* </font><font  style='color: rgb(10,10,10); font-size: 99%; font-weight: bold'><em style='font-size: 76%'>~ Required Field for Form Submission</em></font>";
            $form[] = "\t\t\t</td>";
            $form[] = "\t\t</tr>";
            $form[] = "\t\t<tr>";
            $form[] = "\t</table>";
            $form[] = "</form>";
            break;
                        
    }
    return implode("\n", $form);
        
}

if (!function_exists("checkEmail")) {
    /**
     * checkEmail()
     *
     * @param mixed $email
     * @param mixed $antispam
     * @return bool|mixed
     */
    function checkEmail($email, $antispam = false)
    {
        if (!$email || !preg_match('/^[^@]{1,64}@[^@]{1,255}$/', $email)) {
            return false;
        }
        $email_array      = explode('@', $email);
        $local_array      = explode('.', $email_array[0]);
        $local_arrayCount = count($local_array);
        for ($i = 0; $i < $local_arrayCount; ++$i) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/\=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/\=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
            $domain_array = explode('.', $email_array[1]);
            if (count($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < count($domain_array); ++$i) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }
        if ($antispam) {
            $email = str_replace('@', ' at ', $email);
            $email = str_replace('.', ' dot ', $email);
        }
        
        return $email;
    }
}

function authkey_getAuthKey($minlen = 3, $maxlen = 6, $minseg = 4, $maxseg = 7)
{
    $len = mt_rand($minlen, $maxlen);
    $seg = mt_rand($minseg, $maxseg);
    $key = '';
    for($i=1;$i<=$seg;$i++)
    {
        $xcp = new xcp(NULL, mt_rand(0, 255), $len);
        $key .= $xcp->calc(mt_rand(-microtime(true) * time(), microtime(true) * time()) . XOOPS_DB_PASS);
        if ($i<$seg)
            $key .= '-';
    }
    return $key;
}


function authkey_load_config()
{
    global $xoopsModuleConfig;
    static $moduleConfig;
    
    if (isset($moduleConfig)) {
        return $moduleConfig;
    }
    
    if (isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname", "n") == "authkey") {
        if (!empty($GLOBALS["xoopsModuleConfig"])) {
            $moduleConfig = $GLOBALS["xoopsModuleConfig"];
        } else {
            return null;
        }
    } else {
        $module_handler =& xoops_gethandler('module');
        $module = $module_handler->getByDirname("authkey");
        
        $config_handler =& xoops_gethandler('config');
        $criteria = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
        $configs = $config_handler->getConfigs($criteria);
        foreach (array_keys($configs) as $i) {
            $moduleConfig[$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
        }
        unset($configs);
    }
    if ($customConfig = @include XOOPS_ROOT_PATH . "/modules/authkey/include/plugin.php") {
        $moduleConfig = array_merge($moduleConfig, $customConfig);
    }
    
    return $moduleConfig;
}


if (!function_exists("authkeyGetIP")) {
    
    /* function whitelistGetIP()
     *
     * 	get the True IPv4/IPv6 address of the client using the API
     * @author 		Simon Roberts (Chronolabs) simon@labs.coop
     *
     * @param		boolean		$asString	Whether to return an address or network long integer
     *
     * @return 		mixed
     */
    function authkeyGetIP($asString = true){
        // Gets the proxy ip sent by the user
        $proxy_ip = '';
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else
            if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
                $proxy_ip = $_SERVER['HTTP_X_FORWARDED'];
            } else
                if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
                    $proxy_ip = $_SERVER['HTTP_FORWARDED_FOR'];
                } else
                    if (!empty($_SERVER['HTTP_FORWARDED'])) {
                        $proxy_ip = $_SERVER['HTTP_FORWARDED'];
                    } else
                        if (!empty($_SERVER['HTTP_VIA'])) {
                            $proxy_ip = $_SERVER['HTTP_VIA'];
                        } else
                            if (!empty($_SERVER['HTTP_X_COMING_FROM'])) {
                                $proxy_ip = $_SERVER['HTTP_X_COMING_FROM'];
                            } else
                                if (!empty($_SERVER['HTTP_COMING_FROM'])) {
                                    $proxy_ip = $_SERVER['HTTP_COMING_FROM'];
                                }
                            if (!empty($proxy_ip) && $is_ip = preg_match('/^([0-9]{1,3}.){3,3}[0-9]{1,3}/', $proxy_ip, $regs) && count($regs) > 0)  {
                                $the_IP = $regs[0];
                            } else {
                                $the_IP = $_SERVER['REMOTE_ADDR'];
                            }
                            
                            $the_IP = ($asString) ? $the_IP : ip2long($the_IP);
                            return $the_IP;
    }
}


if (!function_exists("getURIData")) {
    
    /* function yonkURIData()
     *
     * 	Get a supporting domain system for the API
     * @author 		Simon Roberts (Chronolabs) simon@labs.coop
     *
     * @return 		float()
     */
    function getURIData($uri = '', $timeout = 25, $connectout = 25, $post = array(), $headers = array())
    {
        if (!function_exists("curl_init"))
        {
            die("Install PHP Curl Extension ie: $ sudo apt-get install php-curl -y");
        }
        $GLOBALS['php-curl'][md5($uri)] = array();
        if (!$btt = curl_init($uri)) {
            return false;
        }
        if (count($post)==0 || empty($post))
            curl_setopt($btt, CURLOPT_POST, false);
            else {
                $uploadfile = false;
                foreach($post as $field => $value)
                    if (substr($value , 0, 1) == '@' && !file_exists(substr($value , 1, strlen($value) - 1)))
                        unset($post[$field]);
                        else
                            $uploadfile = true;
                            curl_setopt($btt, CURLOPT_POST, true);
                            curl_setopt($btt, CURLOPT_POSTFIELDS, http_build_query($post));
                            
                            if (!empty($headers))
                                foreach($headers as $key => $value)
                                    if ($uploadfile==true && substr($value, 0, strlen('Content-Type:')) == 'Content-Type:')
                                        unset($headers[$key]);
                                        if ($uploadfile==true)
                                            $headers[]  = 'Content-Type: multipart/form-data';
            }
            if (count($headers)==0 || empty($headers))
                curl_setopt($btt, CURLOPT_HEADER, false);
                else {
                    curl_setopt($btt, CURLOPT_HEADER, true);
                    curl_setopt($btt, CURLOPT_HTTPHEADER, $headers);
                }
                curl_setopt($btt, CURLOPT_CONNECTTIMEOUT, $connectout);
                curl_setopt($btt, CURLOPT_TIMEOUT, $timeout);
                curl_setopt($btt, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($btt, CURLOPT_VERBOSE, false);
                curl_setopt($btt, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($btt, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($btt);
                $GLOBALS['php-curl'][md5($uri)]['http']['posts'] = $post;
                $GLOBALS['php-curl'][md5($uri)]['http']['headers'] = $headers;
                $GLOBALS['php-curl'][md5($uri)]['http']['code'] = curl_getinfo($btt, CURLINFO_HTTP_CODE);
                $GLOBALS['php-curl'][md5($uri)]['header']['size'] = curl_getinfo($btt, CURLINFO_HEADER_SIZE);
                $GLOBALS['php-curl'][md5($uri)]['header']['value'] = curl_getinfo($btt, CURLINFO_HEADER_OUT);
                $GLOBALS['php-curl'][md5($uri)]['size']['download'] = curl_getinfo($btt, CURLINFO_SIZE_DOWNLOAD);
                $GLOBALS['php-curl'][md5($uri)]['size']['upload'] = curl_getinfo($btt, CURLINFO_SIZE_UPLOAD);
                $GLOBALS['php-curl'][md5($uri)]['content']['length']['download'] = curl_getinfo($btt, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                $GLOBALS['php-curl'][md5($uri)]['content']['length']['upload'] = curl_getinfo($btt, CURLINFO_CONTENT_LENGTH_UPLOAD);
                $GLOBALS['php-curl'][md5($uri)]['content']['type'] = curl_getinfo($btt, CURLINFO_CONTENT_TYPE);
                curl_close($btt);
                return $data;
    }
}

if (!class_exists("XmlDomConstruct")) {
    /**
     * class XmlDomConstruct
     *
     * 	Extends the DOMDocument to implement personal (utility) methods.
     *
     * @author 		Simon Roberts (Chronolabs) simon@labs.coop
     */
    class XmlDomConstruct extends DOMDocument {
        
        /**
         * Constructs elements and texts from an array or string.
         * The array can contain an element's name in the index part
         * and an element's text in the value part.
         *
         * It can also creates an xml with the same element tagName on the same
         * level.
         *
         * ex:
         * <nodes>
         *   <node>text</node>
         *   <node>
         *     <field>hello</field>
         *     <field>world</field>
         *   </node>
         * </nodes>
         *
         * Array should then look like:
         *
         * Array (
         *   "nodes" => Array (
         *     "node" => Array (
         *       0 => "text"
         *       1 => Array (
         *         "field" => Array (
         *           0 => "hello"
         *           1 => "world"
         *         )
         *       )
         *     )
         *   )
         * )
         *
         * @param mixed $mixed An array or string.
         *
         * @param DOMElement[optional] $domElement Then element
         * from where the array will be construct to.
         *
         * @author 		Simon Roberts (Chronolabs) simon@labs.coop
         *
         */
        public function fromMixed($mixed, DOMElement $domElement = null) {
            
            $domElement = is_null($domElement) ? $this : $domElement;
            
            if (is_array($mixed)) {
                foreach( $mixed as $index => $mixedElement ) {
                    
                    if ( is_int($index) ) {
                        if ( $index == 0 ) {
                            $node = $domElement;
                        } else {
                            $node = $this->createElement($domElement->tagName);
                            $domElement->parentNode->appendChild($node);
                        }
                    }
                    
                    else {
                        $node = $this->createElement($index);
                        $domElement->appendChild($node);
                    }
                    
                    $this->fromMixed($mixedElement, $node);
                    
                }
            } else {
                $domElement->appendChild($this->createTextNode($mixed));
            }
            
        }
        
    }
}
	
	function authkeys_checkperm($op = '', $keyid = 0, $uid = 0) {

		$gperm_handler =& xoops_gethandler('groupperm');
		$config_handler =& xoops_gethandler('config');
		
		$module_handler =& xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname(basename(dirname(__DIR__)));
		$modid = $xoModule->getVar('mid');
		$xoConfig = $config_handler->getConfigList($modid, 0);
		if ($keyid!=0)
		{
		  $key = xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->get($keyid);
		  if (is_object($key) && $key->getVar('uid') != 0)
		      $user = xoops_gethandler('member')->getUser($key->getVar('uid'));
		} elseif ($uid != 0) {
		    $user = xoops_gethandler('member')->getUser($uid);
		}
		$groups = is_object($user) ? $user->getGroups() : (is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS));
		
		switch ($op){
    		case _MI_AUTHKEY_PERM_UNLIMITEDCALLS:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_UNLIMITEDCALLS_ID, $groups, $modid))
    		          return false;
    			return true;
    			break;
    		case _MI_AUTHKEY_PERM_INCREASEONAVG:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_INCREASEONAVG_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_ALLOWPURCHASING:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_ALLOWPURCHASING_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_ALLOWCREATING:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_ALLOWCREATING_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_ALLOWREISSUED:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_ALLOWREISSUED_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_ALLOWVIEWING:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_ALLOWVIEWING_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_ALLOWEDITING:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_ALLOWEDITING_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_ALLOWDELETING:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_ALLOWDELETING_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_STOPISSUINGKEY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_STOPISSUINGKEY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILUSERMONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILUSERMONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILUSER6MONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILUSER6MONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILUSER12MONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILUSER12MONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILUSER24MONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILUSER24MONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILOWNERMONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILOWNERMONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILOWNER6MONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILOWNER6MONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILOWNER12MONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILOWNER12MONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		case _MI_AUTHKEY_PERM_EMAILOWNER24MONTHLY:
    		    if (!$gperm_handler->checkRight(_MI_AUTHKEY_PERM_AUTHKEY, _MI_AUTHKEY_PERM_EMAILOWNER24MONTHLY_ID, $groups, $modid))
    		        return false;
		        return true;
		        break;
    		        
		}  
			
	}
	
	if (!function_exists('xoops_sef')) {
		function xoops_sef($datab, $char ='-')
		{
			$datab = urldecode(strtolower($datab));
			$datab = urlencode($datab);
			$datab = str_replace(urlencode('�'),'ae',$datab);
			$datab = str_replace(urlencode('�'),'oe',$datab);
			$datab = str_replace(urlencode('�'),'aa',$datab);
			$replacement_chars = array(' ', '|', '=', '\\', '+', '-', '_', '{', '}', ']', '[', '\'', '"', ';', ':', '?', '>', '<', '.', ',', ')', '(', '*', '&', '^', '%', '$', '#', '@', '!', '`', '~', '�', '', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�');
			$return_data = str_replace($replacement_chars,$char,urldecode($datab));
			#print $return_data."<BR><BR>";
			switch ($char) {
			default:
				return urldecode($return_data);
				break;
			case "-";
				return urlencode($return_data);
				break;
			}
		}
	}
	
?>