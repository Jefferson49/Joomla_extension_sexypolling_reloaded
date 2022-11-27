<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexypoll.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// import Joomla table library
jimport('joomla.database.table');

class SexyPollTableSexyPoll extends JTable
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__sexy_polls', 'id', $db);
	}
}
