<?php
/**
 * Joomla! component sexypolling
 *
 * Extended by:
 * @version v5.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Access\Access;
use Joomla\CMS\Date\Date;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Session\Session;

//include helper class
require_once JPATH_SITE.'/components/com_sexypolling/helpers/helper.php';
 
 /**
  * Ajax class for SexyPolling module
  */
 class modSexypollingHelper
 {
	 /**
	  * Ajax method for vote
	  *
	  * @return void
	  */
	 public static function voteAjax(): void
	 {
		//Check CSRF token
		if (!Session::checkToken()) {
			echo '[{"invalid":"invalid_token"}]';
			exit();
		}

		$post = Factory::getApplication()->input;
		$db = Factory::getDBO();
		
		//get user groups
		$levels = array();
		$groups = array();
		
		$user = Factory::getUser();
		$user_id = $user->get('id');
		
		$groups = Access::getGroupsByUser($user_id);
		$is_logged_in_user = ( in_array(2,$groups) || in_array(3,$groups) || in_array(6,$groups) || in_array(8,$groups) ) ? true : false;

		//Set UTC as time zone for database values and calculations
		$data_time_zone = 'UTC';

		$current_date = new Date("now", $data_time_zone);
		$date_now = strtotime($current_date->__toString());
		$datenow = HTMLHelper::date($current_date, "Y-m-d H:i:s", $data_time_zone);
		$datenow_sql = HTMLHelper::date($current_date, "Y-m-d", $data_time_zone);
		
		//get ip address		
		$ip = SexypollingHelper::getIp();
		
		$countryname = $post->getString('country_name', 'Unknown');
		$countryname = in_array($countryname, ["", "-"]) ? 'Unknown' : $countryname;
		$cityname = $post->getString('city_name', 'Unknown');
		$cityname = in_array($cityname, ["", "-"]) ? 'Unknown' : $cityname;
		$regionname = $post->getString('region_name', 'Unknown');
		$regionname = in_array($regionname, ["", "-"]) ? 'Unknown' : $regionname;
		$countrycode = $post->getString('country_code', 'Unknown');
		$countrycode = in_array($countrycode, ["", "-"]) ? 'Unknown' : $countrycode;
		
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
		
			$voting_permission_id = $poll_options["voting_permission"];
			$query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
			$db->setQuery($query);
			$db->execute();
			$levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
			if($poll_options["checkacl"] == 1 and !self::if_contain($levels,$groups))
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

		$use_current = $post->get('curr_date', '');
		if($use_current == 'yes') {
			$max_date_sended = HTMLHelper::date("now",'Y-m-d', $data_time_zone).' 23:59:59';
		}
		
		$add_answers = array();
		if(is_array($adittional_answers) && $voting_enabled) {
			foreach ($adittional_answers as $answer) {
				$answer = $db->escape(strip_tags($answer ?? ''));
				$answer = preg_replace('/sexydoublequestionmark/','??',$answer);
		
				$published = 1;
				$query = "INSERT IGNORE INTO `#__sexy_answers` (`id_poll`,`name`,`published`,`created`) VALUES ('$polling_id','$answer','$published','$datenow')";
				$db->setQuery($query);
				$db->execute();
				$insert_id = $db->insertid();
		
				$add_answers[] = $insert_id;
		
				$query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$insert_id','$user_id','$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
				$db->setQuery($query);
				$db->execute();
			}
		}
		
		
		//check if not voted, save the voting
		
		if ($mode != 'view' && $mode != 'view_by_date' && is_array($answer_id_array) && $voting_enabled) {
				foreach ($answer_id_array as $answer_id) {
					$answer_id = (int) $answer_id;
		
					//Only insert vote into datebase if is not related to a newly added answer; in this case vote was already inserted above
					if ($answer_id != 0) {
						$query = "INSERT INTO `#__sexy_votes` (`id_answer`,`id_user`,`ip`,`date`,`country`,`city`,`region`,`countrycode`) VALUES ('$answer_id','$user_id','$ip','$datenow','$countryname','$cityname','$regionname','$countrycode')";
						$db->setQuery($query);
						$db->execute();    
					}
				}
		
				//update max date sended
				$max_date_sended = $datenow_sql.' 23:59:59';
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
			$min_date = HTMLHelper::date($row_total['min_date'], $stringdateformat, $data_time_zone);
			$max_date = HTMLHelper::date($row_total['max_date'], $stringdateformat, $data_time_zone);
		}
		elseif($min_date_sended != ''){
			$min_date = HTMLHelper::date($min_date_sended, $stringdateformat, $data_time_zone);
			$max_date = HTMLHelper::date($max_date_sended, $stringdateformat, $data_time_zone);
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
		usort($order_list, array("modSexypollingHelper", "cmp"));
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
		
		//generates json output
		usort($poll_array, array("modSexypollingHelper", "cmp1"));
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
	}

	/**
	 * Ajax method for addanswer
	 *
	 * @return void
	 */
	public static function addanswerAjax(): void
	{
		//Check CSRF token
		if (!Session::checkToken()) {
			echo '[{"invalid":"invalid_token"}]';
			exit();
		}

		$post = Factory::getApplication()->input;
		$db = Factory::getDBO();
		
		//get user groups
		$levels = array();
		$groups = array();
		
		$user = Factory::getUser();
		$user_id = $user->get('id');
		
		$groups = Access::getGroupsByUser($user_id);
		$is_logged_in_user = ( in_array(2,$groups) || in_array(3,$groups) || in_array(6,$groups) || in_array(8,$groups) ) ? true : false;		

		//Set UTC as time zone for database values and calculations
		$data_time_zone = 'UTC';

		$current_date = new Date("now", $data_time_zone);
		$date_now = strtotime($current_date->__toString());
		$datenow = HTMLHelper::date($current_date, "Y-m-d H:i:s", $data_time_zone);
		$datenow_sql = HTMLHelper::date($current_date, "Y-m-d", $data_time_zone);
		
		//get ip address
		$ip = SexypollingHelper::getIp();

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
		
		$countryname = $post->getString('country_name', 'Unknown');
		$countryname = in_array($countryname, ["", "-"]) ? 'Unknown' : $countryname;
		$cityname = $post->getString('city_name', 'Unknown');
		$cityname = in_array($cityname, ["", "-"]) ? 'Unknown' : $cityname;
		$regionname = $post->getString('region_name', 'Unknown');
		$regionname = in_array($regionname, ["", "-"]) ? 'Unknown' : $regionname;
		$countrycode = $post->getString('country_code', 'Unknown');
		$countrycode = in_array($countrycode, ["", "-"]) ? 'Unknown' : $countrycode;
		
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
		$voting_enabled = true;
		if($poll_options["votechecks"] == 1) {
			//check ACL to vote
		
			//check ACL to add answer
			$add_answer_permissions_id =$poll_options["answerpermission"];
			$query = "SELECT `rules` FROM #__viewlevels WHERE id = '$add_answer_permissions_id'";
			$db->setQuery($query);
			$db->execute();
			$levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
			if(!self::if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
				$voting_enabled = false;
		
			$voting_permission_id = $poll_options["voting_permission"];
			$query = "SELECT `rules` FROM #__viewlevels WHERE id = '$voting_permission_id'";
			$db->setQuery($query);
			$db->execute();
			$levels = explode(',',str_replace(array('[',']'),'',$db->loadResult()));
			if(!self::if_contain($levels,$groups) && $poll_options["checkacl"] == 1)
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
	}	

	/**
	 * Ajax method for geoip
	 *
	 * @return void
	 */
	public static function geoipAjax(): void
	{
		//Check CSRF token
		if (!Session::checkToken()) {
			echo '[{"invalid":"invalid_token"}]';
			exit();
		}

		//get ip address		
		$ip = SexypollingHelper::getIp();
		
		$url = 'http://api.ipinfodb.com/v3/ip-city/?key=4f01028c9fcae27423d5d0cc4489b5679f26febf98d28b90a29c2f3f7531aafd&format=json&ip=' . $ip;
		$ch = curl_init ($url) ;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
		$output = curl_exec($ch) ;
		curl_close($ch) ;
		
		echo $output;		
	}

	/**
	 * Generate CSS as a string to be added to the document as a style 
	 * 
	 * @param int $module_id
	 * @param int $id_category
	 * @param int $id_poll
	 *
	 * @return string
	 */	
    public static function getCSS(int $module_id, int $id_category, int $id_poll): string
    {
		$app = Factory::getApplication();

		$app->input->set('module_id', $module_id);

		if($id_category == 0)
			$app->input->set('id_poll', $id_poll);
		else
			$app->input->set('id_category', $id_category);

		ob_start();
		require (JPATH_BASE.'/modules/mod_sexypolling/generate.css.php');		
		$css = (string) ob_get_clean();

		return $css;
    }	

	/**
	 * if_contain function
	 *
	 * @return bool
	 */

	private static function if_contain($array1,$array2): bool
	{
		if(is_array($array2))
			foreach($array1 as $val) {
			if(in_array($val,$array2))
				return true;
		}
		return false;
	}

	/**
	 * Compare function for usort
	 *
	 * @return bool
	 */
	private static function cmp($a, $b): int
	{
		if ($a[0] == $b[0]) {
			$strcmp = strcasecmp($a[1] ?? '', $b[1] ?? '');
			if ($strcmp > 0)
				return -1;
			elseif($strcmp < 0)
				return 1;
			else
				return 0;
		}
		return ($a[0] < $b[0]) ? -1 : 1;
	}

	/**
	 * Compare function for usort
	 *
	 * @return bool
	 */	
	private static function cmp1($a, $b): int
	{
		if ($a["votes"] == $b["votes"]) {
			return $strcmp = strcasecmp($a["name"] ?? '', $b["name"] ?? '');
		}
		return ($a["votes"] < $b["votes"]) ? 1 : -1;
	}
		
}