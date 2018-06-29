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


    include ('header.php');

    xoops_loadlanguage('main', basename(dirname(__DIR__)));

	xoops_cp_header();
	$indexAdmin = new ModuleAdmin();
	echo $indexAdmin->addNavigation(basename($_SERVER['PHP_SELF']));	
	
 	$indexAdmin = new ModuleAdmin();
 	$indexAdmin->addInfoBox(_AM_AUTHKEY_DASHBOARD);
 	$indexAdmin->addInfoBoxLine(_AM_AUTHKEY_DASHBOARD, "<label>"._AM_AUTHKEY_INDEX_APIS."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getCount(NULL), 'Blue');
 	$indexAdmin->addInfoBoxLine(_AM_AUTHKEY_DASHBOARD, "<label>"._AM_AUTHKEY_INDEX_APIS_AUTHWRITE."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getCount(new Criteria('`api-write`', 'xoopskey')), 'Orange');
 	$indexAdmin->addInfoBoxLine(_AM_AUTHKEY_DASHBOARD, "<label>"._AM_AUTHKEY_INDEX_APIS_AUTHREAD."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getCount(new Criteria('`api-read`', 'xoopskey')), 'Orange');
 	$indexAdmin->addInfoBoxLine(_AM_AUTHKEY_DASHBOARD, "<label>"._AM_AUTHKEY_INDEX_KEYS_NUMBER."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getCount(NULL), 'Green');
 	$indexAdmin->addInfoBoxLine(_AM_AUTHKEY_DASHBOARD, "<label>"._AM_AUTHKEY_INDEX_KEYS_ADVERAGE."</label>", number_format(xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getAveragePerUser(), 2), 'Green');

 	$indexAdmin->addInfoBox(_AM_AUTHKEY_LESTATS);
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_KEY_TYPE."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getNextStatsType(), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_KEY_NAME."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getNextStatsName(), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_KEY_ENDING."</label>", date('Y/m/d H:i:s', xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getNextStatsWhen()), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_USER_TYPE."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getNextStatsType(), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_USER_NAME."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getNextStatsName(), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_USER_ENDING."</label>", date('Y/m/d H:i:s', xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getNextStatsWhen()), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_API_TYPE."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getNextStatsType(), 'Blue');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_API_NAME."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getNextStatsName(), 'Blue');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_LESTATS, "<label>"._AM_AUTHKEY_STATS_API_ENDING."</label>", date('Y/m/d H:i:s', xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getNextStatsWhen()), 'Blue');

    $indexAdmin->addInfoBox(_AM_AUTHKEY_REPORTING);
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_KEY_TYPE."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getNextReportType(), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_KEY_NAME."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getNextReportName(), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_KEY_ENDING."</label>", date('Y/m/d H:i:s', xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getNextReportWhen()), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_USER_TYPE."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getNextReportType(), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_USER_NAME."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getNextReportName(), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_USER_ENDING."</label>", date('Y/m/d H:i:s', xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getNextReportWhen()), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_API_TYPE."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getNextReportType(), 'Blue');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_API_NAME."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getNextReportName(), 'Blue');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_REPORTING, "<label>"._AM_AUTHKEY_REPORT_API_ENDING."</label>", date('Y/m/d H:i:s', xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getNextReportWhen()), 'Blue');
   
    $indexAdmin->addInfoBox(_AM_AUTHKEY_ENDING);
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_KEY_STATS_WEEKLY."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getCountStatsEnding(3600 * 24 * 7), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_KEY_STATS_DAILY."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getCountStatsEnding(3600 * 24), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_KEY_REPORTS_MONTHLY."</label>", xoops_getmodulehandler('keys', basename(dirname(__DIR__)))->getCountReportsEnding(3600 * 24 * 7 * 4), 'Green');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_USER_STATS_WEEKLY."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getCountStatsEnding(3600 * 24 * 7), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_USER_STATS_DAILY."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getCountStatsEnding(3600 * 24), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_USER_REPORTS_MONTHLY."</label>", xoops_getmodulehandler('users', basename(dirname(__DIR__)))->getCountReportsEnding(3600 * 24 * 7 * 4), 'Purple');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_API_STATS_WEEKLY."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getCountStatsEnding(3600 * 24 * 7), 'Blue');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_API_STATS_DAILY."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getCountStatsEnding(3600 * 24), 'Blue');
    $indexAdmin->addInfoBoxLine(_AM_AUTHKEY_ENDING, "<label>"._AM_AUTHKEY_ENDING_API_REPORTS_MONTHLY."</label>", xoops_getmodulehandler('apis', basename(dirname(__DIR__)))->getCountReportsEnding(3600 * 24 * 7 * 4), 'Blue');
    
    echo $indexAdmin->renderIndex();
	xoops_cp_footer();		
?>