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

$ip = $app->input->server->get('REMOTE_ADDR');

$url = 'http://api.ipinfodb.com/v3/ip-city/?key=4f01028c9fcae27423d5d0cc4489b5679f26febf98d28b90a29c2f3f7531aafd&format=json&ip=' . $ip;
$ch = curl_init ($url) ;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
$output = curl_exec($ch) ;
curl_close($ch) ;

echo $output;
?>