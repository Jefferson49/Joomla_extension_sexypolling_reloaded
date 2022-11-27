<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexypolling.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

/*
 * Define constants for all pages
 */
if(!defined('DS')){
	define('DS',DIRECTORY_SEPARATOR);
}
define('JV', (version_compare(JVERSION, '3', 'l')) ? 'j2' : 'j3');
define( 'COM_SEXY_POLLING_DIR', 'images'.DS.'sexy_polling'.DS );
define( 'COM_SEXY_POLLING_BASE', JPATH_ROOT.DS.COM_SEXY_POLLING_DIR );
define( 'COM_SEXY_POLLING_BASEURL', JURI::root().str_replace( DS, '/', COM_SEXY_POLLING_DIR ));

// Require the base controller
require_once JPATH_COMPONENT.DS.'helpers'.DS.'helper.php';

// Initialize the controller
$controller	= JControllerLegacy::getInstance('SexyPolling');

$document = JFactory::getDocument();
$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/icons_'.JV.'.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

// Perform the Request task
if(JV == 'j2')
	$controller->execute( JRequest::getCmd('task'));
else
	$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();