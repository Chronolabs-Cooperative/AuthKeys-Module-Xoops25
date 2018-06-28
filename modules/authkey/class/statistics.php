<?php
/**
 * Authkey API Authentication Statistics for xoops.org
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
class AuthkeyStatistics extends XoopsObject
{
    
    function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('api-id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('key-id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('type', XOBJ_DTYPE_ENUM, null, false, false, false, false, array('hour', 'day', 'week', 'month', 'quarter', 'year', 'user-hour', 'user-day', 'user-week', 'user-month', 'user-quarter', 'user-year', 'api-hour', 'api-day', 'api-week', 'api-month', 'api-quarter', 'api-year'));
        $this->initVar('calls', XOBJ_DTYPE_INT, null, false);
        $this->initVar('limit', XOBJ_DTYPE_INT, null, false);
        $this->initVar('over', XOBJ_DTYPE_INT, null, false);
        $this->initVar('begining', XOBJ_DTYPE_INT, null, false);
        $this->initVar('finished', XOBJ_DTYPE_INT, null, false);
        
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
class AuthkeyStatisticsHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        $this->db = $db;
        parent::__construct($db, 'authkey_statistics', 'AuthkeyStatistics', "id", "key-id");
    }

    function __destruct()
    {
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;      
        @$this->db->queryF("DELETE FROM `" . $this->db->prefix('authkey_statistics') . "` WHERE `begining` < UNIX_TIMESTAMP() - " . $GLOBALS['authkeyConfigsList']['delete-seconds']);
    }
    
    function insert(AuthkeyStatistics $object, $force = true)
    {
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        
        
        if ($object->isNew())
        {
            if ($object->getVar('key-id') > 0)
                $item = xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->get($object->getVar('key-id'));
            elseif ($object->getVar('api-id') > 0)
                $item = xoops_getModuleHandler('apis', basename(dirname(__DIR__)))->get($object->getVar('api-id'));
            if ($object->getVar('uid') > 0)
                $user = xoops_getHandler('users')->get($object->getVar('uid'));
            if ($object->getVar('over') != 0 && $item->getVar('emailed') < time() && $GLOBALS['authkeyConfigsList']['limited'] == true && is_a($item, 'AuthkeyKeys'))
            {
                xoops_load('XoopsMailer');
                $mailer = new XoopsMailer($GLOBALS['xoopsConfig']['sitename'], $GLOBALS['xoopsConfig']['adminemail']);
                if (is_dir(dirname(__DIR__) . DS . 'language' . DS . $GLOBALS['xoopsConfig']['language'] . DS . 'mail_templates'))
                    $mailer->setTemplateDir(dirname(__DIR__) . DS . 'language' . DS . $GLOBALS['xoopsConfig']['language'] . DS . 'mail_templates');
                else
                    $mailer->setTemplateDir(dirname(__DIR__) . DS . 'language' . DS . 'english' . DS . 'mail_templates');
                $mailer->setTemplate('quota_polling_overlimit.txt');
                $mailer->setFromEmail($GLOBALS['xoopsConfig']['adminemail']);
                $mailer->setFromName($GLOBALS['xoopsConfig']['sitename']);
                $mailer->assign('KEY', $item->getVar('key'));
                $mailer->assign('MD5KEY', md5($item->getVar('key')));
                $mailer->assign('SHA1KEY', sha1($item->getVar('key')));
                $mailer->assign('KEY-TITLE', $item->getVar('title'));
                $mailer->assign('KEY-NAME', $item->getVar('name'));
                $mailer->assign('KEY-COMPANY', $item->getVar('company'));
                $mailer->assign('KEY-EMAIL', $item->getVar('email'));
                $mailer->assign('KEY-URL', $item->getVar('url'));
                $mailer->assign('IP', authkeyGetIP(true));
                
                if (is_object($user))
                {
                    $mailer->assign('UNAME', $user->getVar('uname'));
                    $mailer->assign('USERNAME', $user->getVar('name'));
                    $mailer->assign('USEREMAIL', $user->getVar('email'));
                    $mailer->setToEmails(array($user->getVar('email'), $item->getVar('email')));
                } else {
                    $mailer->assign('UNAME', '---');
                    $mailer->assign('USERNAME', $GLOBALS['xoopsConfig']['sitename']);
                    $mailer->assign('USEREMAIL', $GLOBALS['xoopsConfig']['adminemail']);
                    $mailer->setToEmails(array($item->getVar('email')));
                }
                $mailer->assign('LIMITED', ($authkeyConfigsList['limited']==true?_YES:_NO));
                $mailer->assign('PERIODICALLY', constant('_MI_AUTHKEY_PERIODICALLY_'.strtoupper($object->getVar('type'))));
                $mailer->assign('PERIODICAL', constant('_MI_AUTHKEY_PERIODICAL_'.strtoupper($object->getVar('type'))));
                $mailer->assign('LIMITPOLLS', number_format($object->getVar('limit-'.$object->getVar('type')),0));
                $mailer->assign('PURCHASEPOLLS', number_format($authkeyConfigsList['purchase-'.$object->getVar('type')], 0));
                $mailer->assign('PURCHASEAMOUNT', number_format($authkeyConfigsList['purchase-price'], 0));
                $mailer->assign('PURCHASENOMIAL', number_format($authkeyConfigsList['purchase-nomial'], 0));
                if ($authkeyConfigsList['htaccess'])
                    $mailer->assign('PURCHASEURL', XOOPS_URL . "/" . $authkeyConfigsList['baseurl'] . "/purchase/" . $item->getVar('key') . "/" . md5($user->getVar('uname').$user->getVar('pass').$user->getVar('email').$user->getVar('actkey')) . $authkeyConfigsList['endofurl']);
                else
                    $mailer->assign('PURCHASEURL', XOOPS_URL . "/modules/" . basename(dirname(__DIR__)) . "/purchase.php?xoopskey=" . $item->getVar('key') . "&userkey=" . md5($user->getVar('uname').$user->getVar('pass').$user->getVar('email').$user->getVar('actkey')));
                
                $mailer->assign('CALLS', number_format($object->getVar('calls'), 0));
                $mailer->assign('OVER', number_format($object->getVar('over'), 0));
                $mailer->assign('LIMIT', number_format($object->getVar('limit'), 0));
                
                $mailer->setPriority(1);
                $mailer->setSubject(sprintf(_MI_AUTHKEY_SUBJECT_OVERLIMIT, number_format($object->getVar('limit'), 0), number_format($object->getVar('over'), 0)));
                if ($mailer->send(false))
                {
                    $item->setVar('emailed', time() + (mt_rand(5,36) * 3600));
                    @xoops_getModuleHandler('keys', basename(dirname(__DIR__)))->insert($item, $force);
                }
            }
            return parent::insert($object, true);
        }
    }
}

?>