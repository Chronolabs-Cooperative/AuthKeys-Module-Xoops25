<?php
/**
 * Authkey API Authentication Apis for xoops.org
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
class AuthkeyApis extends XoopsObject
{

    function __construct($id = null)
    {
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
		$this->initVar('api-name', XOBJ_DTYPE_TXTBOX, null, false, 128);
		$this->initVar('api-type', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('api-version', XOBJ_DTYPE_TXTBOX, null, false, 6);
		$this->initVar('api-http', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('api-https', XOBJ_DTYPE_TXTBOX, null, false, 64);
		$this->initVar('api-icon', XOBJ_DTYPE_TXTBOX, null, false, 196);
		$this->initVar('api-write', XOBJ_DTYPE_ENUM, null, false, false, false, false, array('xoopskey', 'open', 'userpass'));
		$this->initVar('api-read', XOBJ_DTYPE_ENUM, null, false, false, false, false, array('xoopskey', 'open', 'userpass'));
		$this->initVar('mode', XOBJ_DTYPE_ENUM, null, false, false, false, false, array('http', 'https'));
		$this->initVar('status', XOBJ_DTYPE_ENUM, null, false, false, false, false, array('online', 'offline'));
		$this->initVar('checked', XOBJ_DTYPE_INT, null, false);
		$this->initVar('checking', XOBJ_DTYPE_INT, null, false);
		$this->initVar('online', XOBJ_DTYPE_INT, null, false);
		$this->initVar('offline', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-hour', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-day', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-week', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-month', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-quarter', XOBJ_DTYPE_INT, null, false);
		$this->initVar('calls-year', XOBJ_DTYPE_INT, null, false);
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
class AuthkeyApisHandler extends XoopsPersistableObjectHandler
{
    var $_csv_resources = "https://sourceforge.net/p/xoops/svn/HEAD/tree/%2A.xoops.org%20%28Subdomain%20APIs%20&%20Sites%29/assets/csv/apis-xoops.org.csv?format=raw";
    
    function __construct(&$db) 
    {
        xoops_load('XoopsCache');
        
		$this->db = $db;
        parent::__construct($db, 'authkey_apis', 'AuthkeyApis', "id", "api-name");
        
        if (!$read = XoopsCache::read('xoopskeys_apis'))
        {
            $csv = array_map('str_getcsv', file($this->_csv_resources));
            array_walk($csv, function(&$a) use ($csv) {
                $a = array_combine($csv[0], $a);
            });
            array_shift($csv);
                        
            foreach($csv as $line => $values)
            {
                $criteria = new CriteriaCompo(new Criteria('`api-http`', $this->db->escape($values['API HTTP'])));
                $criteria->add(new Criteria('`api-https`', $this->db->escape($values['API HTTPS'])));
                $criteria->add(new Criteria('`api-type`', $this->db->escape($values['API Type'])));
                
                
                if ($this->getCount($criteria) == 0 && ((isset($values['API Authenticate Write'])?$values['API Authenticate Write']:$values['API Authicate Write']) == 'xoopskey' || (isset($values['API Authenticate Read'])?$values['API Authenticate Read']:$values['API Authicate Read']) == 'xoopskey'))
                {
                    $object = $this->create();
                    $object->setVar('api-name', $values['API Name']);
                    $object->setVar('api-type', $values['API Type']);
                    $object->setVar('api-version', $values['API Version']);
                    $object->setVar('api-http', $values['API HTTP']);
                    $object->setVar('api-https', $values['API HTTPS']);
                    $object->setVar('api-icon', $values['24x24 logo']);
                    $object->setVar('api-write', (isset($values['API Authenticate Write'])?$values['API Authenticate Write']:$values['API Authicate Write']));
                    $object->setVar('api-read', (isset($values['API Authenticate Read'])?$values['API Authenticate Read']:$values['API Authicate Read']));
                    $object->setVar('status', 'offline');
                    $object->setVar('mode', 'http');
                    $object->setVar('checked', time() + mt_rand(1800, 3600*mt_rand(2,7)));
                    $object->setVar('checking', $object->getVar('checked'));
                    @$this->insert($object, true);
                } elseif ($this->getCount($criteria) != 0) {
                    $objects = $this->getObjects($criteria);
                    if (!empty($objects[0]))
                    {
                        $objects[0]->setVar('api-name', $values['API Name']);
                        $objects[0]->setVar('api-type', $values['API Type']);
                        $objects[0]->setVar('api-version', $values['API Version']);
                        $objects[0]->setVar('api-http', $values['API HTTP']);
                        $objects[0]->setVar('api-https', $values['API HTTPS']);
                        $objects[0]->setVar('api-icon', $values['24x24 logo']);
                        $objects[0]->setVar('api-write', (isset($values['API Authenticate Write'])?$values['API Authenticate Write']:$values['API Authicate Write']));
                        $objects[0]->setVar('api-read', (isset($values['API Authenticate Read'])?$values['API Authenticate Read']:$values['API Authicate Read']));
                        @$this->insert($objects[0], true);
                    }
                }
            }
            XoopsCache::write('xoopskeys_apis', array('time'=>time()), 3600 * mt_rand(48, 128));
        }
    }
    
    function getURLSArray()
    {
        static $return = array();
        
        if (empty($return))
        {
            $criteria = new Criteria("1","1");
            $criteria->setOrder('`api-type` ASC, `api-http` ASC, `api-https`');
            $criteria->setSort('ASC');
            $return = array();
            foreach($this->getObjects($criteria) as $key => $object)
            {
                $return[$object->getVar('api-type')][$object->getVar('api-http')] = $object->getVar('api-name');
                $return[$object->getVar('api-type')][$object->getVar('api-https')] = $object->getVar('api-name');
            }
        }
        return $return;
    }
    
    
    function getAPIsText($space = "\t")
    {
        static $return = array();
        
        if (empty($return))
        {
            $criteria = new Criteria("1","1");
            $criteria->setOrder('`api-type` ASC, `api-http` ASC, `api-https`');
            $criteria->setSort('ASC');
            $return = array();
            foreach($this->getObjects($criteria) as $key => $object)
            {
                $return[$object->getVar('id')] = $object->getVar('api-name') . " - " . $object->getVar('api-'.$object->getVar('mode')) . " (".$object->getVar('status').") ~ [Writing Requires: " . $object->getVar('api-write') . " + Reading Requires: " . $object->getVar('api-read') . "]";
            }
        }
        return $space . implode("\n".$space, $return);
    }
    
    function getNextStatsType()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-hour` ASC LIMIT 1";
        $hour = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-day` ASC LIMIT 1";
        $day = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-week` ASC LIMIT 1";
        $week = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-month` ASC LIMIT 1";
        $month = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-quarter` ASC LIMIT 1";
        $quarter = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-year` ASC LIMIT 1";
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
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-hour` ASC LIMIT 1";
        $hour = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-day` ASC LIMIT 1";
        $day = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-week` ASC LIMIT 1";
        $week = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-month` ASC LIMIT 1";
        $month = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-quarter` ASC LIMIT 1";
        $quarter = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-year` ASC LIMIT 1";
        $year = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($hour['stats-hour'] >= $day['stats-day'])
            if ($day['stats-day'] >= $week['stats-week'])
                if ($week['stats-week'] >= $month['stats-month'])
                    if ($month['stats-month'] >= $quarter['stats-quarter'])
                        if ($quarter['stats-quarter'] >= $year['stats-year'])
                            return $year['api-name'];
                        else
                            return $quarter['api-name'];
                    else
                        return $month['api-name'];
                else
                    return $week['api-name'];
            else
                return $day['api-name'];
        else
            return $hour['api-name'];
    }
    
    function getNextStatsWhen()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-hour` ASC LIMIT 1";
        $hour = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-day` ASC LIMIT 1";
        $day = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-week` ASC LIMIT 1";
        $week = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-month` ASC LIMIT 1";
        $month = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-quarter` ASC LIMIT 1";
        $quarter = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `stats-year` ASC LIMIT 1";
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
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-monthly` ASC LIMIT 1";
        $monthly = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-halfyear` ASC LIMIT 1";
        $halfyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-fullyear` ASC LIMIT 1";
        $fullyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-biannual` ASC LIMIT 1";
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
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-monthly` ASC LIMIT 1";
        $monthly = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-halfyear` ASC LIMIT 1";
        $halfyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-fullyear` ASC LIMIT 1";
        $fullyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-biannual` ASC LIMIT 1";
        $biannual = $this->db->fetchArray($this->db->queryF($sql));
        
        if ($monthly['report-monthly'] >= $halfyear['report-halfyear'])
            if ($halfyear['report-halfyear'] >= $fullyear['report-fullyear'])
                if ($fullyear['report-fullyear'] >= $biannual['report-biannual'])
                    return $biannual['api-name'];
                else
                    return $fullyear['api-name'];
            else
                return $halfyear['api-name'];
        else
            return $monthly['api-name'];
    }
    
    function getNextReportWhen()
    {
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-monthly` ASC LIMIT 1";
        $monthly = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-halfyear` ASC LIMIT 1";
        $halfyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-fullyear` ASC LIMIT 1";
        $fullyear = $this->db->fetchArray($this->db->queryF($sql));
        $sql = "SELECT * FROM `" . $this->db->prefix('authkey_apis') . "` ORDER BY `report-biannual` ASC LIMIT 1";
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
    
    function insert(AuthkeyApis $object, $force = true)
    {
        global $authkeyModule, $authkeyConfigsList, $authkeyConfigs, $authkeyConfigsOptions;
        
        if ($object->isNew())
        {
            $object->setVar('created', time());
            $object->setVar('report-monthly', time() + (3600 * 24 * 7 * 4));
            $object->setVar('report-halfyear', time() + (3600 * 24 * 7 * 4 * 6));
            $object->setVar('report-fullyear', time() + (3600 * 24 * 7 * 4 * 12));
            $object->setVar('report-biannual', time() + (3600 * 24 * 7 * 4 * 24));
            $object->setVar('stats-hour', time() + (3600));
            $object->setVar('stats-day', time() + (3600 * 24));
            $object->setVar('stats-week', time() + (3600 * 24 * 7));
            $object->setVar('stats-month', time() + (3600 * 24 * 7 * 4));
            $object->setVar('stats-quarter', time() + (3600 * 24 * 7 * 4 * 3));
            $object->setVar('stats-year', time() + (3600 * 24 * 7 * 4 * 12));
            
        } else {
            $oldobj = $this->get($object->getVar('id'));
            foreach(array('hour', 'day', 'week', 'month', 'quarter', 'year') as $type)
                if ($object->vars['stats-'.$type]['changed'] && $object->getVar('calls-'.$type) != 0)
                {
                    $statisticsHandler = xoops_getModuleHandler('statistics', basename(dirname(__DIR__)));
                    $lestats = $statisticsHandler->create();
                    $lestats->setVar('api-id', $object->getVar('id'));
                    $lestats->setVar('key-id', -1);
                    $lestats->setVar('uid', -1);
                    $lestats->setVar('type', "api-".$type);
                    $lestats->setVar('calls', $object->getVar('calls-'.$type));
                    $lestats->setVar('begining', $oldobj->getVar('stats-'.$type));
                    $lestats->setVar('finished', $object->getVar('stats-'.$type));
                    if ($statisticsHandler->insert($lestats, true))
                    {
                        $object->setVar('calls-'.$type, 0);
                    }
                }
        }
        return parent::insert($object, $force);
    }
}

?>