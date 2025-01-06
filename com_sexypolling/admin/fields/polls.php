<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: polls.php 2012-04-05 14:30:25 svn $
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

use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;

// no direct access
defined('_JEXEC') or die('Restircted access');

class FormFieldPolls extends FormField
{

	protected $type 		= 'sexypolling';

	function getInput()
	{
		$doc 		= Factory::getApplication()->getDocument();
		$fieldName	= $this->name;

		$db = Factory::getContainer()->get('DatabaseDriver');

		$query = "SELECT name text,id value FROM #__sexy_categories WHERE published = '1'";
		$db->setQuery($query);
		$options = $db->loadObjectList();

		$html = array();

		$html[] = "<select name=\"$fieldName\">";
		//$html[] = '<option value="0">'.Text::_("All").'</option>';
		foreach($options AS $o) {
			$html[] = '<option value="'.$o->value.'"'.(($o->value == $this->value) ? ' selected="selected"' : '').'>';
			$html[] = $o->text;
			$html[] = '</option>';
		}
		$html[] = "</select>";

		return implode("", $html);
	}
}
?>
