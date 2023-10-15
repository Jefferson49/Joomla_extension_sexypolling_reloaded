<?php
/**
 * Joomla! 1.5 component sexy_polling
 *
 * @version $Id: polls.php 2012-04-05 14:30:25 svn $
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage sexy_polling
 * @license GNU/GPL
 *
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2023 Jefferson49
 * @license GNU/GPL v3.0
 * 
 * @todo J4 deprecated JFormFieldList 
 */

use Joomla\CMS\Factory;
 
defined('_JEXEC') or die('Restircted access');

class JElementPolls extends JFormFieldList
{
	var	$_name = 'Title';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$doc 		=& Factory::getApplication()->getDocument();
		$fieldName	= $control_name.'['.$name.']';
		$db 		=& Factory::getDBO();

		$query = "SELECT name text,id value FROM #__sexy_categories WHERE published = '1'";
		$db->setQuery($query);
		$options = $db->loadObjectList();

		$html = array();

		$html[] = "<select name=\"$fieldName\">";
		//$html[] = '<option value="0">'.Text::_("All").'</option>';
		foreach($options AS $o) {
			$html[] = '<option value="'.$o->value.'"'.(($o->value == $value) ? ' selected="selected"' : '').'>';
			$html[] = $o->text;
			$html[] = '</option>';
		}
		$html[] = "</select>";

		return implode("", $html);
	}
}
?>
