<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: view.html.php 2012-04-05 14:30:25 svn $
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

use Joomla\CMS\HTML\Helpers\Sidebar;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingViewSexyanswers extends HtmlView {
	
	protected $items;
	protected $pagination;
	protected $state;
	
	/**
	 * Display the view
	 *
	 * @return	void
	 */
    public function display($tpl = null) {
    	
    	$this->items		= $this->get('Items');
    	$this->pagination	= $this->get('Pagination');
    	$this->state		= $this->get('State');
    	$polls	= $this->get('sexyPolls');
 
    	//get category options
    	$options        = array();
    	foreach($polls AS $poll) {
    		$options[]      = HTMLHelper::_('select.option', $poll->id, $poll->name);
    	}

		Sidebar::addFilter(
				Text::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);
			
		Sidebar::addFilter(
				Text::_('COM_SEXYPOLLING_SELECT_POLL'),
				'filter_poll_id',
				HTMLHelper::_('select.options', $options, 'value', 'text', $this->state->get('filter.poll_id'))
		);

       	$this->addToolbar();
		$this->sidebar = Sidebar::render();
		parent::display($tpl);
    }
	    
    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar()
    {
    	ToolbarHelper::addNew('sexyanswer.add');
    	ToolbarHelper::editList('sexyanswer.edit');
	    	
		ToolbarHelper::divider();
 		ToolbarHelper::publish('sexyanswers.publish', 'JTOOLBAR_PUBLISH', true);
		ToolbarHelper::unpublish('sexyanswers.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		ToolbarHelper::deleteList('', 'sexyanswers.delete', 'JTOOLBAR_DELETE');

		ToolbarHelper::divider();
		ToolbarHelper::preferences('com_sexypolling');
    }
    
    /**
     * Returns an array of fields the table can be sorted by
     *
     * @return  array  Array containing the field name to sort by as the key and display text as value
     *
     * @since   3.0
     */
    protected function getSortFields()
    {
    	return array(
    			'sa.ordering' => Text::_('JGRID_HEADING_ORDERING'),
    			'sa.name' => Text::_('COM_SEXYPOLLING_NAME'),
    			'poll_name' => Text::_('COM_SEXYPOLLING_POLL'),
    			'sa.published' => Text::_('JSTATUS'),
    			'count_votes' => Text::_('COM_SEXYPOLLING_NUM_VOTES'),
    			'sa.id' => Text::_('JGRID_HEADING_ID')
    	);
    }
}