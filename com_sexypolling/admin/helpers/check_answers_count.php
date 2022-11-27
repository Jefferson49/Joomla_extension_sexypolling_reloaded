<?php 
/**
 * Joomla! component sexypolling
 *
 * @version $Id: check_answers_count.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
define('_JEXEC',true);
defined('_JEXEC') or die('Restircted access');

error_reporting(0);
include '../../../../configuration.php';

$config = new JConfig;

//conects to datababse
mysql_connect($config->host, $config->user, $config->password);
mysql_select_db($config->db);
mysql_query("SET NAMES utf8");

$id = (int)$_POST['id'];
$res = mysql_query("SELECT COUNT(id) as count_answers FROM `".$config->dbprefix."sexy_answers` WHERE id_poll = '$id' GROUP By id_poll");
$row = mysql_fetch_assoc($res);
echo $count = $row["count_answers"];
?>