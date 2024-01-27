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
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Form\Field\ListField;

// no direct access
defined('_JEXEC') or die('Restircted access');

// import the list field type
FormHelper::loadFieldClass('list');

class FormFieldSexyPoll extends ListField
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'SexyPoll';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of Html options.
	 */
	protected function getOptions() 
	{
		$db = Factory::getContainer()->get('DatabaseDriver');
		$query = $db->getQuery(true);
		$query->select('id,name');
		$query->from('#__sexy_polls');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = HTMLHelper::_('select.option', $message->id, $message->name);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
