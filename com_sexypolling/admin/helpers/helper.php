<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: helper.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingHelper {
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	$vName	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($title, $v, $controller = null, $image = null) {
		$enabled = false;
		$view = JFactory::getApplication()->input->getWord("view", 'sexypolling');
		if($view == $v) {
			$img = $v;
			if($image != null) $img = $image;
			JToolBarHelper::title(   JText::_( $title).' - '.( 'Sexy Polling' ), $img.'.png' );
			$enabled = true;
		}
		$link = 'index.php?option=com_sexypolling&view='.$v;
		if($controller != null) $link .= '&controller='.$controller;
		
		JHtmlSidebar::addEntry( JText::_($title), $link, $enabled);
	}
}