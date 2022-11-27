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
 */

// no direct access
define('_JEXEC',true);
defined('_JEXEC') or die('Restircted access');

/*
 * This is external PHP file and used on AJAX calls, so it has not "defined('_JEXEC') or die;" part.
*/
error_reporting(0);

define( 'DS', DIRECTORY_SEPARATOR );
define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));

session_start();

header('Content-type: application/json');

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$app = JFactory::getApplication('site');
$app->initialise();

$db = JFactory::getDBO();

//get user groups
$levels = array();
$groups = array();

$user = JFactory::getUser();
$user_id = $user->get('id');
jimport( 'joomla.access.access' );
$groups = JAccess::getGroupsByUser($user_id);

$date_now = strtotime("now");
$datenow = date("Y-m-d H:i:s", $date_now);
$datenow_sql = date("Y-m-d", $date_now);

//get ip address
$REMOTE_ADDR = null;
if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { list($REMOTE_ADDR) = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']); }
elseif(isset($_SERVER['HTTP_X_REAL_IP'])) { $REMOTE_ADDR = $_SERVER['HTTP_X_REAL_IP']; }
elseif(isset($_SERVER['REMOTE_ADDR'])) { $REMOTE_ADDR = $_SERVER['REMOTE_ADDR']; }
else { $REMOTE_ADDR = 'Unknown'; }
$ip = $REMOTE_ADDR;

//get post data
$polling_id = (int)$_POST['polling_id'];
$autopublish = (int)$_POST['autopublish'];
$writeinto = (int)$_POST['writeinto'];
$answer = $db->escape(strip_tags($_POST['answer']));
$answer = preg_replace('/sexydoublequestionmark/','??',$answer);

//get poll options
$query = "SELECT * FROM `#__sexy_polls` WHERE `id` = '$polling_id'";
$db->setQuery( $query );
$poll_options = $db->loadAssoc();
$ipcount = $poll_options["ipcount"];
$voting_period = $poll_options["voting_period"];

//check token
if (!JRequest::checkToken() && $poll_options["checktoken"] == 1) {
    echo '[{"invalid":"invalid_token"}]';
    exit();
}

$countryname = (!isset($_POST['country_name']) || $_POST['country_name'] == '' || $_POST['country_name'] == '-' ) ? 'Unknown' : JRequest::getVar('country_name', 'Unknown', 'POST');
$cityname = (!isset($_POST['city_name']) || $_POST['city_name'] == '' || $_POST['city_name'] == '-' ) ? 'Unknown' : JRequest::getVar('city_name', 'Unknown', 'POST');
$regionname = (!isset($_POST['region_name']) || $_POST['region_name'] == '' || $_POST['region_name'] == '-' ) ? 'Unknown' : JRequest::getVar('region_name', 'Unknown', 'POST');
$countrycode = (!isset($_POST['country_code']) || $_POST['country_code'] == '' || $_POST['country_code'] == '-' ) ? 'Unknown' : JRequest::getVar('country_code', 'Unknown', 'POST');

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
    $db->query();
    $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
    if(!if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
        $voting_enabled = false;

    $voting_permission_id = $poll_options["voting_permission"];
    $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
    $db->setQuery($query);
    $db->query();
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
    if($registration_to_vote_required) {
        $query = "SELECT sv.`ip`,sv.`date` FROM #__sexy_votes sv JOIN #__sexy_answers sa ON sa.id_poll = '$polling_id' WHERE sv.id_answer = sa.id AND sv.id_user = '$user_id' ORDER BY sv.`date` DESC LIMIT 1";
        $db->setQuery($query);
        $db->query();
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
        $db->query();
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
        if (isset($_COOKIE["sexy_poll_$polling_id"])) {
            $voting_enabled = false;
        }
    }
}

if(($writeinto == 1 || $autopublish == 0) && $voting_enabled) {
    $published = $autopublish == 1 ? 1 : 0;
    $query = "INSERT INTO `#__sexy_answers` (`id_poll`,`name`,`published`,`created`) VALUES ('$polling_id','$answer','$published','$datenow')";
    $db->setQuery($query);
    $db->query();
    $insert_id = $db->insertid();

    if($ipcountchecked) {
        $query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$insert_id','$user_id','$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
        $db->setQuery($query);
        $db->query();
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