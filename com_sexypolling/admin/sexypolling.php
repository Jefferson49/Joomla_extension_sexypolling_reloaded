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
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/joomla4_plugin_sexy_polling
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

/*
 * Define constants for all pages
 */
define('JV', (version_compare(JVERSION, '3', 'l')) ? 'j2' : 'j3');
define( 'COM_SEXY_POLLING_DIR', 'images'.DIRECTORY_SEPARATOR.'sexy_polling'.DIRECTORY_SEPARATOR );
define( 'COM_SEXY_POLLING_BASE', JPATH_ROOT.DIRECTORY_SEPARATOR.COM_SEXY_POLLING_DIR );
define( 'COM_SEXY_POLLING_BASEURL', JURI::root().str_replace( DIRECTORY_SEPARATOR, '/', COM_SEXY_POLLING_DIR ));

// Require the base controller
require_once JPATH_COMPONENT.DS.'helpers'.DS.'helper.php';

// Initialize the controller
$controller	= JControllerLegacy::getInstance('SexyPolling');

$document = JFactory::getApplication()->getDocument();
$cssFile = JURI::base(true).'/components/com_sexypolling/assets/css/icons_'.JV.'.css';
$document->addStyleSheet($cssFile, 'text/css', null, array());

// Perform the Request task
if(JV == 'j2')
	$controller->execute( JFactory::getApplication()->getInput()->get('task'));
else
	$controller->execute(JFactory::getApplication()->getInput()->get('task'));
$controller->redirect();