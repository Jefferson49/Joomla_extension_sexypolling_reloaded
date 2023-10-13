<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexycategory.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

use Joomla\CMS\Table\Table;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexyPollTableSexyCategory extends Table
{
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function __construct(&$db) 
	{
		parent::__construct('#__sexy_categories', 'id', $db);
	}
}
