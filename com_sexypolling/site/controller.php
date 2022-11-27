<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: controller.php 2012-04-05 14:30:25 svn $
 * @author Simon Poghosyan
 * @package Joomla
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

jimport( 'joomla.application.component.controller' );


/**
 * sexy_polling Controller
 *
 * @package Joomla
 * @subpackage sexy_polling
 */
class SexypollingController extends JControllerLegacy {
	
	/**
	 * @var		string	The default view.
	 * @since	1.6
	 */
	protected $default_view = 'sexypolls';

    public function display($cachable = false, $urlparams = false) {
		parent::display();
    }
}
?>