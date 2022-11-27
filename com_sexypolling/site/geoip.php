<?php 
/**
 * Joomla! component sexypolling
 *
 * @version $Id: geoip.php 2012-04-05 14:30:25 svn $
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
header('Content-type: application/json');

$ip = $_GET[ip];
$url = 'http://api.ipinfodb.com/v3/ip-city/?key=4f01028c9fcae27423d5d0cc4489b5679f26febf98d28b90a29c2f3f7531aafd&format=json&ip=' . $ip;
$ch = curl_init ($url) ;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
$output = curl_exec($ch) ;
curl_close($ch) ;

echo $output;
?>