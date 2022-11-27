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
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

class JFormFieldPolls extends JFormField
{

	protected $type 		= 'sexypolling';

	function getInput()
	{
		$doc 		= JFactory::getDocument();
		$fieldName	= $this->name;

		$db = JFactory::getDBO();

		$query = "SELECT name text,id value FROM #__sexy_categories WHERE published = '1'";
		$db->setQuery($query);
		$options = $db->loadObjectList();

		$html = array();

		$html[] = "<select name=\"$fieldName\">";
		//$html[] = '<option value="0">'.JText::_("All").'</option>';
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
