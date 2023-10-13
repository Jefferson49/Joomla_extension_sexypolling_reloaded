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

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingControllerShowStatistics extends BaseController {

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = Text::_( '' );
		$this->setRedirect( 'index.php?option=com_sexypolling&view=sexystatistics', $msg );
	}
	
}
