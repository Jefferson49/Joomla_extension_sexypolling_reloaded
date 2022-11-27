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
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

abstract class JHtmlSexyPoll
{
	/**
	 * @param	int $value	The featured value
	 * @param	int $i
	 * @param	bool $canChange Whether the value can be changed or not
	 *
	 * @return	string	The anchor tag to toggle featured/unfeatured contacts.
	 * @since	1.6
	 */
	static function featured($value = 0, $i, $canChange = true)
	{
		// Array of image, task, title, action
		$states	= array(
			0	=> array('disabled.png', 'sexypolls.featured', 'COM_SEXYPOLLING_UNFEATURED', 'COM_SEXYPOLLING_UNFEATURED'),
			1	=> array('featured.png', 'sexypolls.unfeatured', 'COM_SEXYPOLLING_FEATURED', 'COM_SEXYPOLLING_FEATURED'),
		);
		$state	= JArrayHelper::getValue($states, (int) $value, $states[1]);
		$html	= JHtml::_('image', 'admin/'.$state[0], JText::_($state[2]), NULL, true);
		if ($canChange) {
			$html	= '<a href="#" onclick="return listItemTask(\'cb'.$i.'\',\''.$state[1].'\')" title="'.JText::_($state[3]).'">'
					. $html .'</a>';
		}

		return $html;
	}
}
