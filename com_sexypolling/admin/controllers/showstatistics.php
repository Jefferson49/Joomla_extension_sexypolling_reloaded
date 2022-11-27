<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: showstatistics.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

jimport( 'joomla.application.component.controller' );

class SexypollingControllerShowStatistics extends JControllerLegacy {

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( '' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexystatistics', $msg );
	}
	
}
