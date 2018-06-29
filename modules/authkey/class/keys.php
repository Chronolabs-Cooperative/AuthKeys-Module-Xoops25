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



if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}
/**
 * Class for Blue Room Xcenter
 * @author Simon Roberts <simon@snails.email>
 * @copyright copyright (c) 2009-2003 XOOPS.org
 * @package kernel
 */
class AuthkeyKeys extends XoopsObject
{

    function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('key', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('name', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('company', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('email', XOBJ_DTYPE_TXTBOX, null, false, 196);
		$this->initVar('url', XOBJ_DTYPE_TXTBOX, null, false, 255);
		$this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-hour', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-day', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-week', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-month', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-quarter', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-year', XOBJ_DTYPE_INT, null, false);
		$this->initVar('overs-hour', XOBJ_DTYPE_INT, null, false);
		$this->initVar('overs-day', XOBJ_DTYPE_INT, null, false);
		$this->initVar('overs-week', XOBJ_DTYPE_INT, null, false);
		$this->initVar('overs-month', XOBJ_DTYPE_INT, null, false);
		$this->initVar('overs-quarter', XOBJ_DTYPE_INT, null, false);
		$this->initVar('overs-year', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit-hour', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit-day', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit-week', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit-month', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit-quarter', XOBJ_DTYPE_INT, null, false);
		$this->initVar('limit-year', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stats-hour', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stats-day', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stats-week', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stats-month', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stats-quarter', XOBJ_DTYPE_INT, null, false);
		$this->initVar('stats-year', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-monthly', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-halfyear', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-fullyear', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-biannual', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
		$this->initVar('issuing', XOBJ_DTYPE_INT, null, false);
		$this->initVar('quoting', XOBJ_DTYPE_INT, null, false);
		$this->initVar('emailed', XOBJ_DTYPE_INT, null, false);
	}
}


/**
* XOOPS policies handler class.
* This class is responsible for providing data access mechanisms to the data source
* of XOOPS user class objects.
*
* @author  Simon Roberts <simon@snails.email>
* @package kernel
*/
class AuthkeyKeysHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'authkey_keys', 'AuthkeyKeys', "id", "key");
    }
    
    function getByXoopsKey($key = '')
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_keys') . "` WHERE `key` LIKE '$key' OR md5(`key`) LIKE '$key' OR sha1(`key`) LIKE '$key'";
        if ($row = $this->db->fetchArray($this->db->queryF($sql)))
        {
            $obj = new AuthkeyKeys();
            $obj->assignVars($row);
            return $obj;
        }
        return false;
    }

    function getUIDs()
    {
        $sql = "SELECT DISTINCT `uid` FROM `" . $this->db->prefix('authkey_keys') . "` GROUP BY `uid`";
        $result = $this->db->queryF($sql);
        $return = array();
        while($row = $this->db->fetchArray($result))
        {
            $return[$row['uid']] = $row['uid'];
        }
        return $return;
    }
    
    function insert(AuthkeyKeys $object, $force = true)
    {
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        
        if ($object->isNew())
        {
            if (!authkeys_checkperm(_MI_AUTHKEY_PERM_STOPISSUINGKEY, false, $object->getVar('uid')))
                return false;
            
            $criteria = new Criteria('uid', $object->getVar('uid'));
            if ($this->getCount($criteria) >= 1)
                if (!authkeys_checkperm(_MI_AUTHKEY_PERM_ALLOWCREATING, false, $object->getVar('uid')))
                    return false;
                    
            $notify = true;
            $object->setVar('created', time());
            $object->setVar('issuing', time());
            if (!strlen(trim($object->getVar('key'))))
                $object->setVar('key', authkey_getAuthKey());
            $object->setVar('limit-hour', $GLOBALS['authkeyConfigsList']['limit-hour']);
            $object->setVar('limit-day', $GLOBALS['authkeyConfigsList']['limit-day']);
            $object->setVar('limit-week', $GLOBALS['authkeyConfigsList']['limit-week']);
            $object->setVar('limit-month', $GLOBALS['authkeyConfigsList']['limit-month']);
            $object->setVar('limit-quarter', $GLOBALS['authkeyConfigsList']['limit-quarter']);
            $object->setVar('limit-year', $GLOBALS['authkeyConfigsList']['limit-year']);
            
            $object->setVar('report-monthly', time() + (3600 * 24 * 7 * 4));
            $object->setVar('report-halfyear', time() + (3600 * 24 * 7 * 4 * 6));
            $object->setVar('report-fullyear', time() + (3600 * 24 * 7 * 4 * 12));
            $object->setVar('report-biannual', time() + (3600 * 24 * 7 * 4 * 24));
            
            $usersHandler = xoops_getModuleHandler('users', basename(dirname(__DIR__)));
            if (!$user = $usersHandler->get($object->getVar('uid')))
            {
                $user = $usersHandler->create();
                $user->setVar('uid', $object->getVar('uid'));
                $user->setVar('report-monthly', time() + (3600 * 24 * 7 * 4));
                $user->setVar('report-halfyear', time() + (3600 * 24 * 7 * 4 * 6));
                $user->setVar('report-fullyear', time() + (3600 * 24 * 7 * 4 * 12));
                $user->setVar('report-biannual', time() + (3600 * 24 * 7 * 4 * 24));
                $user->setVar('created', time());
            }
            
            $user->setVar('limit-hour', $user->getVar('limit-hour') + $object->getVar('limit-hour'));
            $user->setVar('limit-day', $user->getVar('limit-day') + $object->getVar('limit-day'));
            $user->setVar('limit-week', $user->getVar('limit-week') + $object->getVar('limit-week'));
            $user->setVar('limit-month', $user->getVar('limit-month') + $object->getVar('limit-month'));
            $user->setVar('limit-quarter', $user->getVar('limit-quarter') + $object->getVar('limit-quarter'));
            $user->setVar('limit-year', $user->getVar('limit-year') + $object->getVar('limit-year'));
            @$usersHandler->insert($user, true);
            
        } else {
            $oldobj = $this->get($object->getVar('id'));
            foreach(array('hour', 'day', 'week', 'month', 'quarter', 'year') as $type)
                if ($object->vars['stats-'.$type]['changed'] && $object->getVar('calls-'.$type) != 0)
                {
                    $statisticsHandler = xoops_getModuleHandler('statistics', basename(dirname(__DIR__)));
                    $lestats = $statisticsHandler->create();
                    $lestats->setVar('key-id', $object->getVar('id'));
                    $lestats->setVar('uid', $object->getVar('uid'));
                    $lestats->setVar('type', $type);
                    $lestats->setVar('calls', $object->getVar('calls-'.$type));
                    $lestats->setVar('over', $object->getVar('overs-'.$type));
                    $lestats->setVar('limit', $object->getVar('limit-'.$type));
                    $lestats->setVar('begining', $oldobj->getVar('stats-'.$type));
                    $lestats->setVar('finished', $object->getVar('stats-'.$type));
                    if ($statisticsHandler->insert($lestats, true))
                    {
                        $object->setVar('calls-'.$type, 0);
                        $object->setVar('overs-'.$type, 0);
                    }
                }
        }
        $object = $this->get($keyid = parent::insert($object, $force));
        if ($notify == true)
        {
            xoops_load('XoopsMailer');
            $object = $this->get($keyid);
            if ($object->getVar('uid') != 0)
                $user = xoops_getHandler('member')->getUser($object->getVar('uid'));
            $mailer = new XoopsMailer($GLOBALS['xoopsConfig']['sitename'], $GLOBALS['xoopsConfig']['adminemail']);
            if (is_dir(dirname(__DIR__) . DS . 'language' . DS . $GLOBALS['xoopsConfig']['language'] . DS . 'mail_templates'))
                $mailer->setTemplateDir(dirname(__DIR__) . DS . 'language' . DS . $GLOBALS['xoopsConfig']['language'] . DS . 'mail_templates');
            else 
                $mailer->setTemplateDir(dirname(__DIR__) . DS . 'language' . DS . 'english' . DS . 'mail_templates');
            $mailer->setTemplate('issuing_authkey.txt');
            $mailer->setFromEmail($GLOBALS['xoopsConfig']['adminemail']);
            $mailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
            
            $mailer->assign('APIS', xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->getAPIsText("\t * "));
            $mailer->assign('KEY', $object->getVar('key'));
            $mailer->assign('MD5KEY', md5($object->getVar('key')));
            $mailer->assign('SHA1KEY', sha1($object->getVar('key')));
            $mailer->assign('KEY-TITLE', $object->getVar('title'));
            $mailer->assign('KEY-NAME', $object->getVar('name'));
            $mailer->assign('KEY-COMPANY', $object->getVar('company'));
            $mailer->assign('KEY-EMAIL', $object->getVar('email'));
            $mailer->assign('KEY-URL', $object->getVar('url'));
            $mailer->assign('IP', authkeyGetIP(true));
            
            if (is_object($user))
            {
                $mailer->assign('UNAME', $user->getVar('uname'));
                $mailer->assign('USERNAME', $user->getVar('name'));
                $mailer->assign('USEREMAIL', $user->getVar('email'));
                $mailer->setToEmails(array($user->getVar('email'), $object->getVar('email'), $GLOBALS['xoopsConfig']['adminemail']));
            } else {
                $mailer->assign('UNAME', '---');
                $mailer->assign('USERNAME', $GLOBALS['xoopsConfig']['sitename']);
                $mailer->assign('USEREMAIL', $GLOBALS['xoopsConfig']['adminemail']);
                $mailer->setToEmails(array($GLOBALS['xoopsConfig']['adminemail'], $object->getVar('email')));
            }
            $mailer->assign('LIMITED', ($GLOBALS['authkeyConfigsList']['limited']==true?_YES:_NO));
            $mailer->assign('LIMIT-HOUR', $object->getVar('limit-hour'));
            $mailer->assign('LIMIT-DAY', $object->getVar('limit-day'));
            $mailer->assign('LIMIT-WEEK', $object->getVar('limit-week'));
            $mailer->assign('LIMIT-MONTH', $object->getVar('limit-month'));
            $mailer->assign('LIMIT-QUARTER', $object->getVar('limit-quarter'));
            $mailer->assign('LIMIT-YEAR', $object->getVar('limit-year'));
            $mailer->setPriority(1);
            $mailer->setSubject(sprintf(_MI_AUTHKEY_SUBJECT_ISSUINGKEY, $object->getVar('key')));
            if ($mailer->send(false))
            {
                $object->setVar('emailed', time() + (mt_rand(5,36) * 3600));
                @parent::insert($object, $force);
            }
        }
        return $keyid;
    }
}

?>