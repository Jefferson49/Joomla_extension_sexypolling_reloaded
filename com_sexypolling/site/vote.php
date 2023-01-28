<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: vote.php 2012-04-05 14:30:25 svn $
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
error_reporting(0);
header('Content-type: application/json');

define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));

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
$request = JFactory::getApplication()->input->request;

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
$datenow = HtmlHelper::date($date_now, "Y-m-d H:i:s", false);
$datenow_sql = HtmlHelper::date($date_now, "Y-m-d", false);

//get ip address
$REMOTE_ADDR = null;
if($server->get('HTTP_X_FORWARDED_FOR') !== null) { list($REMOTE_ADDR) = explode(',', $server->get('HTTP_X_FORWARDED_FOR')); }
elseif($server->get('HTTP_X_REAL_IP') !== null) { $REMOTE_ADDR = $server->get('HTTP_X_REAL_IP'); }
elseif($server->get('REMOTE_ADDR') !== null) { $REMOTE_ADDR = $server->get('REMOTE_ADDR'); }
else { $REMOTE_ADDR = 'Unknown'; }
$ip = $REMOTE_ADDR;

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

$answer_id_array = $post->get('answer_id', 0);
$adittional_answers = $post->get('answers', 0);
$polling_id = $post->getInt('polling_id', 0,);
$module_id = $post->getInt('module_id', 0);
$mode = $post->get('mode', '');
$min_date_sended = $post->get('min_date') !== null ? $post->get('min_date', '').' 00:00:00' : '';
$max_date_sended = $post->get('max_date') !== null ? $post->get('max_date', '').' 23:59:59' : '';

//escape dates sended to avoid sql injections
$min_date_sended = $db->escape($min_date_sended);
$max_date_sended = $db->escape($max_date_sended);

//get poll options
$query = "SELECT * FROM `#__sexy_polls` WHERE `id` = '$polling_id'";
$db->setQuery( $query );
$poll_options = $db->loadAssoc();
$stringdateformat = $poll_options["stringdateformat"];
$ipcount = $poll_options["ipcount"];
$voting_period = (float) $poll_options["voting_period"];

//check token
if ($poll_options["checktoken"] == 1 and !JFactory::getApplication()->input) {
    echo '[{"invalid":"invalid_token"}]';
    exit();
}

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
$voting_enabled = true;
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

    $voting_permission_id = $poll_options["voting_permission"];
    $query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
    $db->setQuery($query);
    $db->execute();
    $levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
    if($poll_options["checkacl"] == 1 and !if_contain($levels,$groups))
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
        if($ipcount != 0 && $num_rows >= $ipcount) {
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

$use_current = $post->get('curr_date', '');
if($use_current == 'yes') {
    $max_date_sended = HtmlHelper::date(strtotime("now"),'Y-m-d',false).' 23:59:59';
}

$add_answers = array();
if(is_array($adittional_answers) && $voting_enabled) {
    foreach ($adittional_answers as $answer) {
        $answer = $db->escape(strip_tags($answer));
        $answer = preg_replace('/sexydoublequestionmark/','??',$answer);

        $published = 1;
        $query = "INSERT INTO `#__sexy_answers` (`id_poll`,`name`,`published`,`created`) VALUES ('$polling_id','$answer','$published',NOW())";
        $db->setQuery($query);
        $db->execute();
        $insert_id = $db->insertid();

        $add_answers[] = $insert_id;

        $query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$insert_id','$user_id',$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
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


//check if not voted, save the voting

if ($mode != 'view' && $mode != 'view_by_date' && is_array($answer_id_array) && $voting_enabled) {
        foreach ($answer_id_array as $answer_id) {
            $answer_id = (int)$answer_id;
            $query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$answer_id','$user_id','$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
            $db->setQuery($query);
            $db->execute();
        }

		//update max date sended
		$max_date_sended = $datenow_sql.' 23:59:59';

        //set the cookie
        if($voting_period == 0) {
            $expire = time()+(60*60*24*365*2);//2 years
            setcookie("sexy_poll_$polling_id", $date_now, $expire, '/');
        }
        else {
            $expire_time = (float)$voting_period*60*60;
			$time = time();
            $expire = (int)(time()+$expire_time);
            setcookie("sexy_poll_$polling_id", $date_now, $expire, '/');
        }
}

//get count of total votes, min and max dates of voting
$query_toal = "SELECT
                COUNT(sv.`id_answer`) total_count,
                MAX(sv.`date`) max_date,
                MIN(sv.`date`) min_date
            FROM
                `#__sexy_votes` sv
            JOIN
                `#__sexy_answers` sa ON sa.id_poll =  '$polling_id'
            AND
                sa.published = '1'
            WHERE
                sv.`id_answer` = sa.id";

//if dates are sended, add them to query
if ($min_date_sended != '' && $max_date_sended != '')
    $query_toal .= " AND sv.`date` >= '$min_date_sended' AND sv.`date` <= '$max_date_sended' ";

$db->setQuery($query_toal);
$db->execute();
$row_total = $db->loadAssoc();

$count_total_votes = $row_total['total_count'];
if ($count_total_votes > 0) {
    $min_date = HtmlHelper::date(strtotime($row_total['min_date']),$stringdateformat, false);
    $max_date = HtmlHelper::date(strtotime($row_total['max_date']),$stringdateformat, false);
}
elseif($min_date_sended != ''){
    $min_date = HtmlHelper::date(strtotime($min_date_sended),$stringdateformat, false);
    $max_date = HtmlHelper::date(strtotime($max_date_sended),$stringdateformat, false);
}
else {
    $max_date = "";
    $min_date = "";
}

//get all answers
$answer_ids = array();
$voted_ids = array();
$ans_names = array();
$ans_orders_start = array();
$query = "SELECT `id`,`name` FROM `#__sexy_answers` WHERE `id_poll` = '$polling_id' AND  published = '1' ORDER BY `ordering` DESC,name";
$db->setQuery($query);
$row_all_array = $db->loadAssocList();
$a = 1;
if(is_array($row_all_array))
foreach ($row_all_array as $row_all) {
    $answer_ids[] = $row_all['id'];
    $ans_names[$row_all['id']] = $row_all['name'];
    $ans_orders_start[$row_all['id']] = $a;
    $a ++;
}

//get answers votes data
$query_poll =
                "
                    SELECT
                        sv.id_answer,
                        sa.name,
                        COUNT(sv.`id_answer`) count_votes
                    FROM
                        `#__sexy_votes` sv
                    JOIN
                        `#__sexy_answers` sa ON sa.id_poll =  '$polling_id'
                    AND
                        sa.published = '1'
                    WHERE
                        sv.`id_answer` = sa.id";
if ($min_date_sended != '' && $max_date_sended != '')
    $query_poll .= " AND sv.`date` >= '$min_date_sended' AND sv.`date` <= '$max_date_sended' ";
$query_poll .= " GROUP BY sv.`id_answer` ORDER BY count_votes DESC,sa.name";
$db->setQuery($query_poll);
$row_poll_array = $db->loadAssocList();

$poll_array = Array();
if(is_array($row_poll_array))
foreach ($row_poll_array as $row_poll) {

    $float_percent = (100 * $row_poll['count_votes'] / $count_total_votes);
    $item_percent = number_format($float_percent, 1, '.', '');

    $poll_array[$row_poll['id_answer']]['percent'] = $float_percent;
    $poll_array[$row_poll['id_answer']]['percent_formated'] = $item_percent;
    $poll_array[$row_poll['id_answer']]['answer_id'] = $row_poll['id_answer'];
    $poll_array[$row_poll['id_answer']]['votes'] = $row_poll['count_votes'];
    $poll_array[$row_poll['id_answer']]['total_votes'] = $count_total_votes;
    $poll_array[$row_poll['id_answer']]['min_date'] = $min_date;
    $poll_array[$row_poll['id_answer']]['max_date'] = $max_date;
    $poll_array[$row_poll['id_answer']]['name'] = $row_poll['name'];

    $voted_ids[] = $row_poll['id_answer'];
}

//chech if there are answers with no votes
foreach ($answer_ids as $ans_id) {
    if(!in_array($ans_id,$voted_ids)) {
        $poll_array["$ans_id"]['percent'] = '0';
        $poll_array["$ans_id"]['percent_formated'] = '0';
        $poll_array["$ans_id"]['answer_id'] = $ans_id;
        $poll_array["$ans_id"]['votes'] = '0';
        $poll_array["$ans_id"]['total_votes'] = $count_total_votes;
        $poll_array["$ans_id"]['min_date'] = $min_date;
        $poll_array["$ans_id"]['max_date'] = $max_date;
        $poll_array["$ans_id"]['name'] = $ans_names[$ans_id];
    }
}

//genertes order list
$order_list = array();
foreach ($poll_array as $data) {
    $order_list[$data['answer_id']] = array($data['votes'],$data['name'],$data['answer_id']);
}
usort($order_list, "cmp");
$r = 1;
$ord_final_list = array();
foreach ($order_list as $k => $val) {
    $ord_final_list[$k] = $r;
    $r++;
}

$order_list = array_reverse($order_list,true);

//print_r($order_list);

$r = 1;
$ord_final_list = array();
foreach ($order_list as $k => $val) {
    $ord_final_list[$val[2]] = $r;
    $r++;
}

//print_r($ord_final_list);

function cmp($a, $b)
{
    if ($a[0] == $b[0]) {
        $strcmp = strcasecmp($a[1], $b[1]);
        if ($strcmp > 0)
            return -1;
        elseif($strcmp < 0)
            return 1;
        else
            return 0;
    }
    return ($a[0] < $b[0]) ? -1 : 1;
}

function cmp1($a, $b)
{
    if ($a["votes"] == $b["votes"]) {
        return $strcmp = strcasecmp($a["name"], $b["name"]);
    }
    return ($a["votes"] < $b["votes"]) ? 1 : -1;
}


//generates json output
usort($poll_array, "cmp1");
//print_r($poll_array);
$a = 0;
echo '[';
foreach ($poll_array as $data)
{
    echo '{';
    echo '"answer_id": "'.$data["answer_id"].'", ';
    echo '"poll_id": "'.$polling_id.'", ';
    echo '"module_id": "'.$module_id.'", ';
    echo '"percent_formated": "'.$data["percent_formated"].'", ';
    echo '"percent": "'.$data["percent"].'", ';
    echo '"votes": "'.$data["votes"].'", ';
    echo '"total_votes": "'.$data["total_votes"].'", ';
    echo '"min_date": "'.$data["min_date"].'", ';
    echo '"order": "'.$ord_final_list[$data["answer_id"]].'", ';
    echo '"order_start": "'.$ans_orders_start[$data["answer_id"]].'", ';
    //echo '"name": "'.str_replace('\\','', htmlspecialchars (stripslashes($data["name"]),ENT_QUOTES)).'", ';
    echo '"max_date": "'.$data["max_date"].'"';

    if(sizeof($add_answers) > 0 && $a == 0) {
        echo ', "addedanswers": ';
        echo '[';
        foreach ($add_answers as $k => $ans_id) {
            echo '"'.$ans_id.'"';
            if ($k != sizeof($add_answers) - 1)
                echo ',';
        }
        echo ']';
    }

    echo '}';
    if ($a != sizeof($poll_array) - 1)
        echo ', ';
    $a++;
}
echo ']';

jexit();
?>