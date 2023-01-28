<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: addanswer.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\Date\Date;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Language\Language;

// no direct access
define('_JEXEC',true);
defined('_JEXEC') or die('Restircted access');

/*
 * This is external PHP file and used on AJAX calls, so it has not "defined('_JEXEC') or die;" part.
*/
define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));

error_reporting(0);
header('Content-type: application/json');

require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'defines.php' );
require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'framework.php' );

if(version_compare(JVERSION, '4', '>=')) {
	// Boot the DI container.
	$container = \Joomla\CMS\Factory::getContainer();

	// Alias the session service key to the web session service.
	$container->alias(\Joomla\Session\SessionInterface::class, 'session.web.site');

	// Get the application.
	$app = $container->get(\Joomla\CMS\Application\SiteApplication::class);
}
else {
	// Get the application.
	$app = JFactory::getApplication('site');
	$app->initialise();
}

$post = JFactory::getApplication()->input->post;
$server = JFactory::getApplication()->input->server;

//load language and timezone
$lang_tag = $app->input->cookie->getString('sexy_poll_lang_tag', 'en-GB');
$time_zone = $app->input->cookie->getString('sexy_poll_time_zone', '');
JFactory::$language = new Language($lang_tag);
//Create date format
$date = new Date();
$date_time_zone = new DateTimeZone($time_zone);
$date->setTimezone($date_time_zone);
$debug_date = HtmlHelper::date('now', Text::_('Y-F-d H:i:s'), false);

$db = JFactory::getDBO();

//get user groups
$levels = array();
$groups = array();

$user = JFactory::getUser();
$user_id = $user->get('id');
jimport( 'joomla.access.access' );
$groups = JAccess::getGroupsByUser($user_id);
$is_logged_in_user = ( in_array(2,$groups) || in_array(3,$groups) || in_array(6,$groups) || in_array(8,$groups) ) ? true : false;

$date_now = strtotime("now");
$datenow = HtmlHelper::date($date_now,"Y-m-d H:i:s", false);
$datenow_sql = HtmlHelper::date($date_now,"Y-m-d", false);

//get ip address
$REMOTE_ADDR = null;
if($server->get('HTTP_X_FORWARDED_FOR') !== null) { list($REMOTE_ADDR) = explode(',', $server->get('HTTP_X_FORWARDED_FOR')); }
elseif($server->get('HTTP_X_REAL_IP') !== null) { $REMOTE_ADDR = $server->get('HTTP_X_REAL_IP'); }
elseif($server->get('REMOTE_ADDR') !== null) { $REMOTE_ADDR = $server->get('REMOTE_ADDR'); }
else { $REMOTE_ADDR = 'Unknown'; }
$ip = $REMOTE_ADDR;

//get post data
$polling_id = $post->getInt('polling_id');
$autopublish = $post->getInt('autopublish');
$writeinto = $post->getInt('writeinto');
$answer = $db->escape(htmlspecialchars($post->getString('answer', '')));
$answer = preg_replace('/sexydoublequestionmark/','??',$answer);

//get poll options
$query = "SELECT * FROM `#__sexy_polls` WHERE `id` = '$polling_id'";
$db->setQuery( $query );
$poll_options = $db->loadAssoc();
$ipcount = $poll_options["ipcount"];
$voting_period = (float) $poll_options["voting_period"];

//check token
if (!JFactory::getApplication()->input && $poll_options["checktoken"] == 1) {
    echo '[{"invalid":"invalid_token"}]';
    exit();
}

$countryname = $post->get('country_name', 'Unknown');
$countryname = $countryname === "" ? 'Unknown' : $countryname;
$cityname = $post->get('city_name', 'Unknown');
$cityname = $cityname === "" ? 'Unknown' : $cityname;
$regionname = $post->get('region_name', 'Unknown');
$regionname = $regionname === "" ? 'Unknown' : $regionname;
$countrycode = $post->get('country_code', 'Unknown');
$countrycode = $countrycode === "" ? 'Unknown' : $countrycode;

$ip = $db->escape($ip);
$countryname = $db->escape($countryname);
$cityname = $db->escape($cityname);
$regionname = $db->escape($regionname);
$countrycode = $db->escape($countrycode);

//check ipcount security
$query = "SELECT COUNT( sv.ip )
            FROM  `#__sexy_answers` sa
            JOIN  `#__sexy_votes` sv ON sv.id_answer = sa.id
            AND DATE_FORMAT(sv.date, '%Y-%m-%d') = '$datenow_sql'
            AND sv.ip = '$ip'
            WHERE sa.id_poll =  '$polling_id'
        ";
$db->setQuery($query);
$count_votes = $db->loadResult();
$ipcountchecked = true;
if($ipcount != 0 && $count_votes >= $ipcount)
    $ipcountchecked = false;

//make additional checkings
$voting_enabled = true;
if($poll_options["votechecks"] == 1) {
    //check ACL to vote
    function if_contain($array1,$array2) {
        if(is_array($array2))
            foreach($array1 as $val) {
            if(in_array($val,$array2))
                return true;
        }
        return false;
    }

    //check ACL to add answer
    $add_answer_permissions_id =$poll_options["answerpermission"];
    $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$add_answer_permissions_id'";
    $db->setQuery($query);
    $db->execute();
    $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
    if(!if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
        $voting_enabled = false;

    $voting_permission_id = $poll_options["voting_permission"];
    $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
    $db->setQuery($query);
    $db->execute();
    $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
    if(!if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
        $voting_enabled = false;

    $registration_to_vote_required = ( in_array(2,$levels) || in_array(3,$levels) || in_array(6,$levels) || in_array(8,$levels) ) ? true : false;

    //check start,end dates
    if($poll_options["date_start"] != '0000-00-00' &&  $date_now < strtotime($poll_options["date_start"]))
        $voting_enabled = false;
    if($poll_options["date_end"] != '0000-00-00' &&  $date_now > strtotime($poll_options["date_end"]))
        $voting_enabled = false;

    //check user_id
    if($registration_to_vote_required OR $is_logged_in_user) {
        $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$polling_id' WHERE sv.id_answer = sa.id AND sv.id_user = '$user_id' ORDER BY sv.`date` DESC LIMIT 1";
        $db->setQuery($query);
        $db->execute();
        $num_rows = $db->getNumRows();
        $row = $db->loadAssoc();
        if($num_rows > 0) {
            $datevoted = strtotime($row['date']);
            $hours_diff = ($date_now - $datevoted) / 3600;
            if($voting_period == 0 || ($hours_diff < $voting_period)) {
                $voting_enabled = false;
            }
        }
    }
    else {
        //check ip
        $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$polling_id' WHERE sv.id_answer = sa.id AND sv.ip = '$ip' ORDER BY sv.`date` DESC LIMIT 1";
        $db->setQuery($query);
        $db->execute();
        $num_rows = $db->getNumRows();
        $row = $db->loadAssoc();
        if($num_rows > 0) {
            $datevoted = strtotime($row['date']);
            $hours_diff = ($date_now - $datevoted) / 3600;
            if($voting_period == 0 || ($hours_diff < $voting_period)) {
                $voting_enabled = false;
            }
        }
		
        //check cookie		
		if (JFactory::getApplication()->input->cookie->get('sexy_poll_$polling_id') !== null) {
            $voting_enabled = false;
        }
    }
}

if(($writeinto == 1 || $autopublish == 0) && $voting_enabled) {
    $published = $autopublish == 1 ? 1 : 0;
    $query = "INSERT IGNORE INTO `#__sexy_answers` (`id_poll`,`name`,`published`,`created`) VALUES ('$polling_id','$answer','$published','$datenow')";
    $db->setQuery($query);
    $db->execute();
    $insert_id = $db->insertid();

    if($ipcountchecked) {
        $query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$insert_id','$user_id','$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
        $db->setQuery($query);
        $db->execute();
        //set the cookie
        if($voting_period == 0) {
            $expire = time()+(60*60*24*365*2);//2 years
            setcookie("sexy_poll_$polling_id", $date_now, $expire, '/');
        }
        else {
            $expire_time = (float)$voting_period*60*60;
            $expire = (int)(time()+$expire_time);
            setcookie("sexy_poll_$polling_id", $date_now, $expire, '/');
        }
    }
}
else {
    $insert_id = 0;
}

echo json_encode(array(array('answer' => $answer, 'id' => $insert_id)));
jexit();
?>