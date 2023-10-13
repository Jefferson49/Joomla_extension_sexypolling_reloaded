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

use Joomla\CMS\MVC\Controller\BaseController;

// no direct access
defined('_JEXEC') or die('Restircted access');

/**
 * sexy_polling Controller
 *
 * @package Joomla
 * @subpackage sexy_polling
 */
class SexypollingController extends BaseController {
	
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