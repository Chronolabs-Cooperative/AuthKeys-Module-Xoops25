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

function getHTMLForm($mode = '')
{
    $form = array();
    switch ($mode)
    {
        case "getkey":
            $form[] = "<form name='auth-key' method=\"POST\" enctype=\"multipart/form-data\" action=\"" . XOOPS_URL . '/modules/' . basename(dirname(__DIR__)) . '/api/?mode=getkey">';
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
            $form[] = "<form name='new-domain' method=\"POST\" enctype=\"multipart/form-data\" action=\"" . XOOPS_URL . '/modules/' . basename(dirname(__DIR__)) . '/api/?mode=verify">';
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
	
	function xcenter_checkperm($op, $fct, $storyid, $catid, $blockid, $securitymode) {

		$gperm_handler =& xoops_gethandler('groupperm');
		$config_handler =& xoops_gethandler('config');
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
		$module_handler =& xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname('xcenter');
		$modid = $xoModule->getVar('mid');
		$xoConfig = $config_handler->getConfigList($modid, 0);
		if (strlen($securitymode)==0)
			$securitymode = $xoConfig['security'];
		
		switch ($op){
		case _XTR_URL_OP_SAVE:
			switch($securitymode)  {
			default:
			case _XTR_SECURITY_BASIC:
				return true;
				break;
			case _XTR_SECURITY_INTERMEDIATE:
			case _XTR_SECURITY_ADVANCED:
				switch ($fct) {
				case _XTR_URL_FCT_PAGES;
					foreach($catid as $id => $val)
						if (!$gperm_handler->checkRight(_XTR_PERM_MODE_ADD._XTR_PERM_TYPE_CATEGORY,$val,$groups, $modid))
							return false;
					return true;
					break;
				case _XTR_URL_FCT_XCENTER:
					if ($storyid==0) 
						return $gperm_handler->checkRight(_XTR_PERM_MODE_ADD._XTR_PERM_TYPE_XCENTER,$catid,$groups, $modid);
					else
						return true;
					break;		
				}
				break;
			}
		case _XTR_URL_OP_EDIT:
			switch($securitymode)  {
			case _XTR_SECURITY_BASIC:
			case _XTR_SECURITY_INTERMEDIATE:
				switch ($fct) {
				case _XTR_URL_FCT_XCENTER:
					return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_XCENTER,$groups, $modid);
					break;		
				case _XTR_URL_FCT_CATEGORY:
				case _XTR_URL_FCT_CATEGORIES:
					return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_CATEGORY,$groups, $modid);
					break;		
				case _XTR_URL_FCT_BLOCK:
				case _XTR_URL_FCT_BLOCKS:
					return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_BLOCK,$groups, $modid);
					break;															
				}
				break;
			case _XTR_SECURITY_ADVANCED:
				switch ($fct) {
				case _XTR_URL_FCT_XCENTER:
					if (!$gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_XCENTER,$groups, $modid))
						return false;
					return $gperm_handler->checkRight(_XTR_PERM_MODE_EDIT._XTR_PERM_TYPE_XCENTER,$storyid,$groups, $modid);
					break;		
				case _XTR_URL_FCT_CATEGORY:
				case _XTR_URL_FCT_CATEGORIES:
					if (!$gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_CATEGORY,$groups, $modid))
						return false;
					return $gperm_handler->checkRight(_XTR_PERM_MODE_EDIT._XTR_PERM_TYPE_CATEGORY,$catid,$groups, $modid);
					break;		
				case _XTR_URL_FCT_BLOCK:
				case _XTR_URL_FCT_BLOCKS:
					if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_EDIT_BLOCK,$groups, $modid))
						return false;
					return $gperm_handler->checkRight(_XTR_PERM_MODE_EDIT._XTR_PERM_TYPE_BLOCK,$blockid,$groups, $modid);
					break;															
				}
				break;
			}
		case _XTR_URL_OP_ADD:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCK:
			case _XTR_URL_FCT_BLOCKS:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_ADD_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_DELETE:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_DELETE_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_DELETE_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCK:
			case _XTR_URL_FCT_BLOCKS:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_DELETE_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_COPY:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_COPY_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_COPY_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCK:
			case _XTR_URL_FCT_BLOCKS:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_COPY_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_MANAGE:
			switch ($fct) {
			case _XTR_URL_FCT_XCENTER:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_XCENTER,$groups, $modid);
				break;		
			case _XTR_URL_FCT_CATEGORY:
			case _XTR_URL_FCT_CATEGORIES:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_CATEGORY,$groups, $modid);
				break;		
			case _XTR_URL_FCT_BLOCKS:
			case _XTR_URL_FCT_BLOCK:
				return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_MANAGE_BLOCK,$groups, $modid);
				break;															
			}
			break;
		case _XTR_URL_OP_PERMISSIONS:
			return $gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,_XTR_PERM_TEMPLATE_PERMISSIONS,$groups, $modid);
			break;
		}
			
	}
	
	function loadUserMenu($currentoption, $breadcrumb = "")
	{
		$adminmenu = array();

		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_XCENTER]['title'] = _XTR_XCENTER_ADMENU1;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_XCENTER]['link']  = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_XCENTER;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_XCENTER]['title'] = _XTR_XCENTER_ADMENU2;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_XCENTER]['link']  = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_XCENTER;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_CATEGORY]['title'] = _XTR_XCENTER_ADMENU3;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_CATEGORY]['link']  = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_CATEGORIES;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_CATEGORY]['title'] = _XTR_XCENTER_ADMENU4;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_CATEGORY]['link']  = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_CATEGORY;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_BLOCK]['title'] = _XTR_XCENTER_ADMENU5;
		$adminmenu[_XTR_PERM_TEMPLATE_MANAGE_BLOCK]['link']  = "manage.php?op="._XTR_URL_OP_MANAGE."&fct="._XTR_URL_FCT_BLOCKS;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_BLOCK]['title'] = _XTR_XCENTER_ADMENU6;
		$adminmenu[_XTR_PERM_TEMPLATE_ADD_BLOCK]['link']  = "manage.php?op="._XTR_URL_OP_ADD."&fct="._XTR_URL_FCT_BLOCKS;
		$adminmenu[_XTR_PERM_TEMPLATE_PERMISSIONS]['title'] = _XTR_XCENTER_ADMENU7;
		$adminmenu[_XTR_PERM_TEMPLATE_PERMISSIONS]['link']  = "manage.php?op="._XTR_URL_OP_PERMISSIONS."&fct="._XTR_URL_FCT_TEMPLATE.'&mode='._XTR_PERM_MODE_ALL;

		$breadcrumb = empty($breadcrumb) ? $adminmenu[$currentoption]["title"] : $breadcrumb;
		$module_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/";
		$image_link = XOOPS_URL."/modules/".$GLOBALS["xoopsModule"]->getVar("dirname")."/images";
		
		$adminmenu_text ='
		<style type="text/css">
		<!--
		#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0;}
		#buttonbar { float:left; width:100%; background: #e7e7e7 url("'.$image_link.'/modadminbg.gif") repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 12px;}
		#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		#buttonbar li { display:inline; margin:0; padding:0; }
		#buttonbar a { float:left; background:url("'.$image_link.'/left_both.gif") no-repeat left top; margin:0; padding:0 0 0 9px; border-bottom:1px solid #000; text-decoration:none; }
		#buttonbar a span { float:left; display:block; background:url("'.$image_link.'/right_both.gif") no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		/* Commented Backslash Hack hides rule from IE5-Mac \*/
		#buttonbar a span {float:none;}
		/* End IE5-Mac hack */
		#buttonbar a:hover span { color:#333; }
		#buttonbar .current a { background-position:0 -150px; border-width:0; }
		#buttonbar .current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		#buttonbar a:hover { background-position:0% -150px; }
		#buttonbar a:hover span { background-position:100% -150px; }    
		//-->
		</style>
		<div id="buttontop">
		 <table style="width: 100%; padding: 0; " cellspacing="0">
			 <tr>
				 <td style="width: 70%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">
					 <a href="index.php">'.$GLOBALS["xoopsModule"]->getVar("name").'</a>
				 </td>
				 <td style="width: 30%; font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;">
					 <strong>'.$GLOBALS["xoopsModule"]->getVar("name").'</strong>&nbsp;'.$breadcrumb.'
				 </td>
			 </tr>
		 </table>
		</div>
		<div id="buttonbar">
		 <ul>
		';
		
		$gperm_handler =& xoops_gethandler('groupperm');
		$groups = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getGroups() : array(XOOPS_GROUP_ANONYMOUS);
		$module_handler =& xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname(_XTR_DIRNAME);
		$modid = $xoModule->getVar('mid');
	
		foreach (array_keys($adminmenu) as $key) {
			$j++;
			if ($gperm_handler->checkRight(_XTR_PERM_MODE_ALL._XTR_PERM_TYPE_TEMPLATE,$key,$groups, $modid))
				$adminmenu_text .= (($currentoption == $j) ? '<li class="current">' : '<li>').'<a href="'.$module_link.$adminmenu[$key]["link"].'"><span>'.$adminmenu[$key]["title"].'</span></a></li>';
		}
		 $adminmenu_text .= '</ul>
		</div>
		<br style="clear:both;" />';
		
		return $adminmenu_text;
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
	
	if (!function_exists('clear_unicodeslashes')){
		function clear_unicodeslashes($text) {
			$text = str_replace(array("\\'"), "'", $text);
			$text = str_replace(array("\\\\\\'"), "'", $text);
			$text = str_replace(array('\\"'), '"', $text);
			return $text;
		}
	}
	
	function xcenter_getBreadcrumb($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('parent_id')!=0)
			$children = xcenter_getChildrenTree(array(), $storyid);
		else
			$children = array(0 => $storyid);
		
		$crumb = array();
		$j = 0;
		foreach(array_reverse($children) as $storyid) {
			$j++;
			$crumb[$storyid]['title'] = xcenter_getField($storyid, 'title');
			$crumb[$storyid]['ptitle'] = xcenter_getField($storyid, 'ptitle');
			$crumb[$storyid]['url'] = XOOPS_URL.'/modules/xcenter/?storyid='.$storyid;
			if ($j==count($children))
				$crumb[$storyid]['last'] = true;
		}
		return $crumb;
	}

	function xcenter_getChildrenTree($children, $storyid=0)
	{
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('parent_id')!=0){
			$children[$storyid] = $storyid;
			$children = xcenter_getChildrenTree($children, $xcenter->getVar('parent_id'));
		} else
			$children[$storyid] = $storyid;
		return $children;	
	}


	function xcenter_passkey()
	{
		return md5(sha1(XOOPS_LICENSE_KEY).date('Ymd'));
	}
	
	function xcenter_getPageTitle($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('catid')>0) {
			return xcenter_getTitle($storyid)._XTR_PAGETITLESEP.xcenter_getCatTitle($xcenter->getVar('catid'));
		} else {
			return xcenter_getTitle($storyid);
		}
	}
	
	function xcenter_getMetaKeywords($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('catid')>0) {
			return xcenter_getField($storyid, 'keywords'). ', '. xcenter_getCatField($xcenter->getVar('catid'), 'keywords');
		} else {
			return xcenter_getField($storyid, 'keywords');
		}
	}

	function xcenter_getMetaDescription($storyid) {
		$xcenter_handler =& xoops_getmodulehandler(_XTR_CLASS_XCENTER, _XTR_DIRNAME);
		$xcenter = $xcenter_handler->get($storyid);
		if ($xcenter->getVar('catid')>0) {
			$catid = $xcenter->getVar('catid');
			$desc = xcenter_getField($storyid, 'page_description');
			if (empty($desc)) 
				return xcenter_getCatField($catid, 'page_description');
			else
				return $desc;
		} else {
			return xcenter_getField($storyid, 'page_description');
		}
	}
	
	function xcenter_getTitle($storyid) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));
		if ($texts = $text_handler->getObjects($criteria)){
			return $texts[0]->getVar('title');
		} else {
			$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));	
			if ($texts = $text_handler->getObjects($criteria)){
				return $texts[0]->getVar('title');
			} else {
				return _XTR_NOTITLESPECIFIED;
			}
		} 
	}
	
	function xcenter_getBlockTitle($blockid) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));
		if ($texts = $text_handler->getObjects($criteria)){
			return $texts[0]->getVar('title');
		} else {
			$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));	
			if ($texts = $text_handler->getObjects($criteria)){
				return $texts[0]->getVar('title');
			} else {
				return _XTR_NOTITLESPECIFIED;
			}
		} 
	}	
	
	function xcenter_getCatTitle($catid) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('catid', $catid));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));		
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		if ($texts = $text_handler->getObjects($criteria)){
			return $texts[0]->getVar('title');
		} else {
			$criteria = new CriteriaCompo(new Criteria('catid', $catid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));	
			if ($texts = $text_handler->getObjects($criteria)){
				return $texts[0]->getVar('title');
			} else {
				return _XTR_NOTCATITLESPECIFIED;
			}
		} 
	}

	function xcenter_getField($storyid, $field) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));
		if ($texts = $text_handler->getObjects($criteria)){
			return clear_unicodeslashes($texts[0]->getVar($field));
		} else {
			$criteria = new CriteriaCompo(new Criteria('storyid', $storyid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_XCENTER));	
			if ($texts = $text_handler->getObjects($criteria)){
				return clear_unicodeslashes($texts[0]->getVar($field));
			} else {
				return '';
			}
		} 
	}
	
	function xcenter_getCatField($catid, $field) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('catid', $catid));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));		
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		if ($texts = $text_handler->getObjects($criteria)){
			return clear_unicodeslashes($texts[0]->getVar($field));
		} else {
			$criteria = new CriteriaCompo(new Criteria('catid', $catid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_CATEGORY));	
			if ($texts = $text_handler->getObjects($criteria)){
				return clear_unicodeslashes($texts[0]->getVar($field));
			} else {
				return '';
			}
		} 
	}

	function xcenter_getBlockField($blockid, $field) {
		$text_handler =& xoops_getmodulehandler(_XTR_CLASS_TEXT, _XTR_DIRNAME);
		$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
		$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));		
		$criteria->add(new Criteria('language', $GLOBALS['xoopsConfig']['language']));
		if ($texts = $text_handler->getObjects($criteria)){
			return clear_unicodeslashes($texts[0]->getVar($field));
		} else {
			$criteria = new CriteriaCompo(new Criteria('blockid', $blockid));
			$criteria->add(new Criteria('type', _XTR_ENUM_TYPE_BLOCK));	
			if ($texts = $text_handler->getObjects($criteria)){
				return clear_unicodeslashes($texts[0]->getVar($field));
			} else {
				return '';
			}
		} 
	}

?>