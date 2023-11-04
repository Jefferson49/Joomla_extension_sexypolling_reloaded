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
 * @copyright Copyright (c) 2022 - 2023 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Language;
use Joomla\CMS\Session\Session;

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

//Check CSRF token
if (!Session::checkToken()) {
    echo '[{"invalid":"invalid_token"}]';
    exit();
}

$post = JFactory::getApplication()->input->post;
$server = JFactory::getApplication()->input->server;

//load language and timezone
$lang_tag = $app->input->cookie->getString('sexy_poll_lang_tag', 'en-GB');
$user_time_zone = $app->input->cookie->getString('sexy_poll_time_zone', 'Europe/London');
JFactory::$language = new Language($lang_tag);

//Set UTC as time zone for database values and calculations
$data_time_zone = 'UTC';

$db = JFactory::getDBO();

//get user groups
$levels = array();
$groups = array();

$user = JFactory::getUser();
$user_id = $user->get('id');
jimport( 'joomla.access.access' );
$groups = JAccess::getGroupsByUser($user_id);
$is_logged_in_user = ( in_array(2,$groups) || in_array(3,$groups) || in_array(6,$groups) || in_array(8,$groups) ) ? true : false;

$date_now = strtotime(HTMLHelper::date("now", "Y-m-d H:i:s", $data_time_zone));
$datenow = HTMLHelper::date("now", "Y-m-d H:i:s", $data_time_zone);
$datenow_sql = HTMLHelper::date("now", "Y-m-d", $data_time_zone);

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

//as a default, voting is enabled
$voting_enabled = true;

//if is logged in user, query otes per user
if($is_logged_in_user) {
    $query = "SELECT COUNT( sv.ip )
        FROM  `#__sexy_answers` sa
        JOIN  `#__sexy_votes` sv ON sv.id_answer = sa.id
        AND sv.id_user = '$user_id'
        WHERE sa.id_poll =  '$polling_id'
    ";
}
//otherwise query votes per IP
else {
    $query = "SELECT COUNT( sv.ip )
        FROM  `#__sexy_answers` sa
        JOIN  `#__sexy_votes` sv ON sv.id_answer = sa.id
        AND sv.ip = '$ip'
        WHERE sa.id_poll =  '$polling_id'
    ";
}

$db->setQuery($query);
$count_votes = $db->loadResult();

//if number of votes exceeds max votes per user or IP
if($ipcount != 0 && $count_votes >= $ipcount)
    $voting_enabled = false;

//make additional checkings
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

    //check ACL (acces control) to add answer
    $add_answer_permissions_id =$poll_options["answerpermission"];
    $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$add_answer_permissions_id'";
    $db->setQuery($query);
    $db->execute();
    $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
    if(!if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
        $voting_enabled = false;

    //check voting permission of user
    $voting_permission_id = $poll_options["voting_permission"];
    $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
    $db->setQuery($query);
    $db->execute();
    $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
    if(!if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
        $voting_enabled = false;

    //check start,end dates
    if($poll_options["date_start"] != '0000-00-00' &&  $date_now < strtotime($poll_options["date_start"]))
        $voting_enabled = false;
    if($poll_options["date_end"] != '0000-00-00' &&  $date_now > strtotime($poll_options["date_end"]))
        $voting_enabled = false;

    //query votes per user id
    if($is_logged_in_user) {
        $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$polling_id' WHERE sv.id_answer = sa.id AND sv.id_user = '$user_id' ORDER BY sv.`date` DESC";
    }
    //query votes per ip
    else {
        $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$polling_id' WHERE sv.id_answer = sa.id AND sv.ip = '$ip' ORDER BY sv.`date` DESC";
    }

    //check time difference to last vote
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

if(($writeinto == 1 || $autopublish == 0) && $voting_enabled) {
    $published = $autopublish == 1 ? 1 : 0;
    $query = "INSERT IGNORE INTO `#__sexy_answers` (`id_poll`,`name`,`published`,`created`) VALUES ('$polling_id','$answer','$published','$datenow')";
    $db->setQuery($query);
    $db->execute();
    $insert_id = $db->insertid();

    $query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$insert_id','$user_id','$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
    $db->setQuery($query);
    $db->execute();
}
else {
    $insert_id = 0;
}

echo json_encode(array(array('answer' => $answer, 'id' => $insert_id)));
jexit();
?>