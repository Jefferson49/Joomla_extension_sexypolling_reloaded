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
 * @copyright Copyright (c) 2022 - 2025 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\Access\Access;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\Helpers\Sidebar;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\Registry\Registry;

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
		$view = Factory::getApplication()->input->getWord("view", 'sexypolling');
		if($view == $v) {
			$img = $v;
			if($image != null) $img = $image;
			ToolbarHelper::title(   Text::_( $title).' - '.( 'Sexy Polling' ), $img.'.png' );
			$enabled = true;
		}
		$link = 'index.php?option=com_sexypolling&view='.$v;
		if($controller != null) $link .= '&controller='.$controller;
		
		Sidebar::addEntry( Text::_($title), $link, $enabled);
	}
	
	/**
	 * Get the actions
	*/
	public static function getActions($component = '', $section = '', $messageId = 0)
	{	
		$result = new Registry;

		if (empty($messageId)) {
			$assetName = 'com_sexypolling';
		}
		else {
			$assetName = 'com_sexypolling.message.'.(int) $messageId;
		}

		$actions = Access::getActionsFromData('com_sexypolling', 'component');

		foreach ($actions as $action) {
			$value = Factory::getApplication()->getIdentity()->authorise($action->name, $assetName);
			$result->set($action->name, $value);
		}

		return $result;
	}

	public static function getContexts()
	{
	Factory::getApplication()->getLanguage()->load('com_sexypolling', JPATH_ADMINISTRATOR);

		$contexts = array(
			'com_sexypolling.sexyanswer' => Text::_('COM_SEXYPOLLING_ANSWER'),
			'com_sexypolling.categories' => Text::_('JCATEGORY')
		);

		return $contexts;
	}
	
	public static function validateSection($section, $item)
	{
		if (Factory::getApplication()->isClient('site') && $section == 'form')
		{
			return 'sexyanswer';
		}
		if ($section != 'sexyanswer' && $section != 'form')
		{
			return null;
		}

		return $section;
	}
}