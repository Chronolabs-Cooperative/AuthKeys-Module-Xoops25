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

    function __construct($uid = null)
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
		$this->initVar('report-monthly', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-halfyear', XOBJ_DTYPE_INT, null, false);
		$this->initVar('report-fullyear', XOBJ_DTYPE_INT, null, false);
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
    
    function getNextStatsType()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-hour` ASC LIMIT 1";
        $hour = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-day` ASC LIMIT 1";
        $day = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-week` ASC LIMIT 1";
        $week = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-month` ASC LIMIT 1";
        $month = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-quarter` ASC LIMIT 1";
        $quarter = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-year` ASC LIMIT 1";
        $year = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($hour['stats-hour'] >= $day['stats-day'])
            if ($day['stats-day'] >= $week['stats-week'])
                if ($week['stats-week'] >= $month['stats-month'])
                    if ($month['stats-month'] >= $quarter['stats-quarter'])
                        if ($quarter['stats-quarter'] >= $year['stats-year'])
                            return _MI_AUTHKEY_PERIODICALLY_YEAR;
                        else
                            return _MI_AUTHKEY_PERIODICALLY_QUARTER;
                    else
                        return _MI_AUTHKEY_PERIODICALLY_MONTH;
                else
                    return _MI_AUTHKEY_PERIODICALLY_WEEK;
            else
                return _MI_AUTHKEY_PERIODICALLY_DAY;
        else
            return _MI_AUTHKEY_PERIODICALLY_HOUR;
    }
    
    function getNextStatsName()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-hour` ASC LIMIT 1";
        $hour = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-day` ASC LIMIT 1";
        $day = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-week` ASC LIMIT 1";
        $week = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-month` ASC LIMIT 1";
        $month = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-quarter` ASC LIMIT 1";
        $quarter = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-year` ASC LIMIT 1";
        $year = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($hour['stats-hour'] >= $day['stats-day'])
            if ($day['stats-day'] >= $week['stats-week'])
                if ($week['stats-week'] >= $month['stats-month'])
                    if ($month['stats-month'] >= $quarter['stats-quarter'])
                        if ($quarter['stats-quarter'] >= $year['stats-year'])
                            $user = xoops_getHandler('member')->getUser($year['uid']);
                        else
                            $user = xoops_getHandler('member')->getUser($quarter['uid']);
                    else
                        $user = xoops_getHandler('member')->getUser($month['uid']);
                else
                    $user = xoops_getHandler('member')->getUser($week['uid']);
            else
                $user = xoops_getHandler('member')->getUser($day['uid']);
        else
            $user = xoops_getHandler('member')->getUser($hour['uid']);
        
        if (is_object($user))
            if (strlen($user->getVar('name')))
                return $user->getVar('name') . " (" . $user->getVar('uname') . ")";
            else 
                return $user->getVar('uname');
       return '';
    }
    
    function getNextStatsWhen()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-hour` ASC LIMIT 1";
        $hour = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-day` ASC LIMIT 1";
        $day = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-week` ASC LIMIT 1";
        $week = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-month` ASC LIMIT 1";
        $month = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-quarter` ASC LIMIT 1";
        $quarter = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `stats-year` ASC LIMIT 1";
        $year = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($hour['stats-hour'] >= $day['stats-day'])
            if ($day['stats-day'] >= $week['stats-week'])
                if ($week['stats-week'] >= $month['stats-month'])
                    if ($month['stats-month'] >= $quarter['stats-quarter'])
                        if ($quarter['stats-quarter'] >= $year['stats-year'])
                            return $year['stats-year'];
                        else
                            return $quarter['stats-quarter'];
                    else
                        return $month['stats-month'];
                else
                    return $week['stats-week'];
            else
                return $day['stats-day'];
        else
            return $hour['stats-hour'];
    }
    
    function getNextReportType()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-monthly` ASC LIMIT 1";
        $monthly = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-halfyear` ASC LIMIT 1";
        $halfyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-fullyear` ASC LIMIT 1";
        $fullyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-biannual` ASC LIMIT 1";
        $biannual = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($monthly['report-monthly'] >= $halfyear['report-halfyear'])
            if ($halfyear['report-halfyear'] >= $fullyear['report-fullyear'])
                if ($fullyear['report-fullyear'] >= $biannual['report-biannual'])
                    return _MI_AUTHKEY_PERIODICALLY_BIANNUAL;
                else
                    return _MI_AUTHKEY_PERIODICALLY_FULLYEAR;
            else
                return _MI_AUTHKEY_PERIODICALLY_HALFYEAR;
        else
            return _MI_AUTHKEY_PERIODICALLY_MONTH;
    }
    
    function getNextReportName()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-monthly` ASC LIMIT 1";
        $monthly = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-halfyear` ASC LIMIT 1";
        $halfyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-fullyear` ASC LIMIT 1";
        $fullyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-biannual` ASC LIMIT 1";
        $biannual = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($monthly['report-monthly'] >= $halfyear['report-halfyear'])
            if ($halfyear['report-halfyear'] >= $fullyear['report-fullyear'])
                if ($fullyear['report-fullyear'] >= $biannual['report-biannual'])
                    $user = xoops_getHandler('member')->getUser($biannual['uid']);
                else
                    $user = xoops_getHandler('member')->getUser($fullyear['uid']);
            else
                $user = xoops_getHandler('member')->getUser($halfyear['uid']);
        else
            $user = xoops_getHandler('member')->getUser($monthly['uid']);
        
        if (is_object($user))
            if (strlen($user->getVar('name')))
                return $user->getVar('name') . " (" . $user->getVar('uname') . ")";
            else
                return $user->getVar('uname');
        return '';
                        
    }
    
    function getNextReportWhen()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-monthly` ASC LIMIT 1";
        $monthly = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-halfyear` ASC LIMIT 1";
        $halfyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-fullyear` ASC LIMIT 1";
        $fullyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_users') . "` ORDER BY `report-biannual` ASC LIMIT 1";
        $biannual = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($monthly['report-monthly'] >= $halfyear['report-halfyear'])
            if ($halfyear['report-halfyear'] >= $fullyear['report-fullyear'])
                if ($fullyear['report-fullyear'] >= $biannual['report-biannual'])
                    return $biannual['report-biannual'];
                else
                    return $fullyear['report-fullyear'];
            else
                return $halfyear['report-halfyear'];
        else
            return $monthly['report-monthly'];
    }
    
    
    function getCountStatsEnding($seconds = 0)
    {
        $criteriahour = new CriteriaCompo(new Criteria('`stats-hour`', time() - $seconds, ">="));
        $criteriahour->add(new Criteria('`stats-hour`', time(), "<="));
        $criteriaday = new CriteriaCompo(new Criteria('`stats-day`', time() - $seconds, ">="));
        $criteriaday->add(new Criteria('`stats-day`', time(), "<="));
        $criteriaweek = new CriteriaCompo(new Criteria('`stats-week`', time() - $seconds, ">="));
        $criteriaweek->add(new Criteria('`stats-week`', time(), "<="));
        $criteriamonth = new CriteriaCompo(new Criteria('`stats-month`', time() - $seconds, ">="));
        $criteriamonth->add(new Criteria('`stats-month`', time(), "<="));
        $criteriaquarter = new CriteriaCompo(new Criteria('`stats-quarter`', time() - $seconds, ">="));
        $criteriaquarter->add(new Criteria('`stats-quarter`', time(), "<="));
        $criteriayear = new CriteriaCompo(new Criteria('`stats-year`', time() - $seconds, ">="));
        $criteriayear->add(new Criteria('`stats-year`', time(), "<="));
        $criteria = new CriteriaCompo($criteriahour);
        $criteria->add($criteriaday, 'OR');
        $criteria->add($criteriaweek, 'OR');
        $criteria->add($criteriamonth, 'OR');
        $criteria->add($criteriaquarter, 'OR');
        $criteria->add($criteriayear, 'OR');
        return $this->getCount($criteria);
    }
    
    
    function getCountReportsEnding($seconds = 0)
    {
        $criteriamonthly = new CriteriaCompo(new Criteria('`report-monthly`', time() - $seconds, ">="));
        $criteriamonthly->add(new Criteria('`report-monthly`', time(), "<="));
        $criteriahalfyear = new CriteriaCompo(new Criteria('`report-halfyear`', time() - $seconds, ">="));
        $criteriahalfyear->add(new Criteria('`report-halfyear`', time(), "<="));
        $criteriafullyear = new CriteriaCompo(new Criteria('`report-fullyear`', time() - $seconds, ">="));
        $criteriafullyear->add(new Criteria('`report-fullyear`', time(), "<="));
        $criteriabiannual = new CriteriaCompo(new Criteria('`report-biannual`', time() - $seconds, ">="));
        $criteriabiannual->add(new Criteria('`report-biannual`', time(), "<="));
        $criteria = new CriteriaCompo($criteriamonthly);
        $criteria->add($criteriahalfyear, 'OR');
        $criteria->add($criteriafullyear, 'OR');
        $criteria->add($criteriabiannual, 'OR');
        return $this->getCount($criteria);
    }
    
    function insert(AuthkeyUsers $object, $force = true)
    {
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        
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