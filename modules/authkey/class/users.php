<?php
/**
 * Authkey API Authentication Users for xoops.org
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
class AuthkeyUsers extends XoopsObject
{

    function AuthkeyUsers($uid = null)
    {
        $this->initVar('uid', XOBJ_DTYPE_INT, null, false);
		$this->initVar('uname', XOBJ_DTYPE_TXTBOX, null, false, 128);
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
		$this->initVar('report-month', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-quarter', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-year', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-biannual', XOBJ_DTYPE_INT, null, false);
		$this->initVar('created', XOBJ_DTYPE_INT, null, false);
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
class AuthkeyUsersHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
		$this->db = $db;
        parent::__construct($db, 'authkey_users', 'AuthkeyUsers', "uid", "uname");
    }
    
    function insert(AuthkeyUsers $object, $force = true)
    {
        
        if ($object->isNew())
        {
            if ($object->getVar('stats-hour') <= time())
                $object->setVar('stats-hour', time() + (3600));
            if ($object->getVar('stats-day') <= time())
                $object->setVar('stats-day', time() + (3600 * 24));
            if ($object->getVar('stats-week') <= time())
                $object->setVar('stats-week', time() + (3600 * 24 * 7));
            if ($object->getVar('stats-month') <= time())
                $object->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
            if ($object->getVar('stats-quarter') <= time())
                $object->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
            if ($object->getVar('stats-year') <= time())
                $object->setVar('stats-year', time() + (3600 * 24 * 7 * 4 * 12));
            
        } else {
            $oldobj = $this->get($object->getVar('uid'));
            foreach(array('hour', 'day', 'week', 'month', 'quarter', 'year') as $type)
                if ($object->vars['stats-'.$type]['changed'] && $object->getVar('calls-'.$type) != 0)
                {
                    $statisticsHandler = xoops_getModuleHandler('statistics', basename(dirname(__DIR__)));
                    $lestats = $statisticsHandler->create();
                    $lestats->setVar('key-id', -1);
                    $lestats->setVar('uid', $object->getVar('uid'));
                    $lestats->setVar('type', "user-".$type);
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
        return parent::insert($object, $force);
    }
}

?>