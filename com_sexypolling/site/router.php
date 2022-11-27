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

/*
 * Function to convert a system URL to a SEF URL
 */
function SexypollingBuildRoute( &$query )
{
	static $items;
	$app	= JFactory::getApplication();

	$segments	= array();
	$itemid		= null;

	// Break up the poll id into numeric and alias values.
	if (isset($query['id']) && strpos($query['id'], ':')) {
		list($query['id'], $query['alias']) = explode(':', $query['id'], 2);
	}

	// Get the menu items for this component.
	if (!$items) {
		$component	= JComponentHelper::getComponent('com_sexypolling');
		$menu	= $app->getMenu();
		$items		= $menu->getItems('component_id', $component->id);
	}

	// Search for an appropriate menu item.
	if (is_array($items))
	{
		// If only the option and itemid are specified in the query, return that item.
		if (!isset($query['view']) && !isset($query['id']) && !isset($query['catid']) && isset($query['Itemid'])) {
			$itemid = (int) $query['Itemid'];
		}
		// Search for a specific link based on the critera given.
		if (!$itemid) {
			foreach ($items as $item)
			{
				// Check if this menu item links to this view.
				if (isset($item->query['view']) && $item->query['view'] == 'sexypolls'
					&& isset($query['view']) && $query['view'] != 'category'
					&& isset($item->query['id']) && $item->query['id'] == $query['id'])
				{
					$itemid	= $item->id;
				}
			}
		}

		// If no specific link has been found, search for a general one.
		if (!$itemid) {
			foreach ($items as $item)
			{
				if (isset($query['view']) && $query['view'] == 'sexypolls' && isset($item->query['view']) && $item->query['view'] == 'sexypolls')
				{
					// Check for an undealt with newsfeed id.
					if (isset($query['id']))
					{
						// This menu item links to the newsfeed view but we need to append the newsfeed id to it.
						$itemid		= $item->id;
						$segments[]	= isset($query['alias']) ? $query['id'].':'.$query['alias'] : $query['id'];
						break;
					}
				}
			}
		}
	}

	// Check if the router found an appropriate itemid.
	if (!$itemid)
	{
		// Check if a id was specified.
		if (isset($query['id']))
		{
			if (isset($query['alias'])) {
				$query['id'] .= ':'.$query['alias'];
			}

			// Push the id onto the stack.
			$segments[] = $query['id'];
			unset($query['id']);
			unset($query['alias']);
		}
		unset($query['view']);
	}
	else
	{
		$query['Itemid'] = $itemid;

		// Remove the unnecessary URL segments.
		unset($query['view']);
		unset($query['id']);
		unset($query['catid']);
		unset($query['alias']);
	}

	return $segments;
}

/**
 * @param	array
 * @return	array
 */
function SexypollingParseRoute( $segments )
{
	$vars = array();

	//Get the active menu item
	$menu	=& JSite::getMenu();
	$item	=& $menu->getActive();

	$count	= count( $segments );

	//Standard routing for articles
	if(!isset($item))
	{
		$vars['id']    = $segments[$count - 1];
		return $vars;
	}

	// Count route segments
	$vars['id']		= $segments[$count-1];
	$vars['view']	= 'sexypolls';

	return $vars;
}