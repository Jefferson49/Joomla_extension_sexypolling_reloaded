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

define('JPATH_BASE', dirname(dirname(dirname(__FILE__))));

require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'defines.php' );
require_once ( JPATH_BASE .DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'framework.php' );

//conects to datababse
$db = JFactory::getDBO();

$id = JFactory::getApplication()->input->post->getInt('id');
$query = "SELECT COUNT(id) as count_answers FROM #__sexy_answers WHERE id_poll = '$id' GROUP By id_poll";
$db->setQuery($query);
$db->execute();
$row = $db->loadAssoc();

echo $count = $row["count_answers"];
?>