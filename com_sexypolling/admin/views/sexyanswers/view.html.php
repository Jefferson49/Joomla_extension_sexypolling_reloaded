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
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewSexyanswers extends JViewLegacy {
	
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
    		$options[]      = JHtml::_('select.option', $poll->id, $poll->name);
    	}
    	if(JV == 'j2') {
    		$this->poll_options = $options;
    	}
    	else {
    		JHtmlSidebar::addFilter(
    				JText::_('JOPTION_SELECT_PUBLISHED'),
    				'filter_published',
    				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
    		);
    		 
    		JHtmlSidebar::addFilter(
    				JText::_('COM_SEXYPOLLING_SELECT_POLL'),
    				'filter_poll_id',
    				JHtml::_('select.options', $options, 'value', 'text', $this->state->get('filter.poll_id'))
    		);
    	}
       	$this->addToolbar();
       	if(JV == 'j3')
       		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
    }
	    
    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar()
    {
    	JToolBarHelper::addNew('sexyanswer.add');
    	JToolBarHelper::editList('sexyanswer.edit');
	    	
		JToolBarHelper::divider();
 		JToolBarHelper::publish('sexyanswers.publish', 'JTOOLBAR_PUBLISH', true);
		JToolBarHelper::unpublish('sexyanswers.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::deleteList('', 'sexyanswers.delete', 'JTOOLBAR_DELETE');
	    
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
    			'sa.ordering' => JText::_('JGRID_HEADING_ORDERING'),
    			'sa.name' => JText::_('COM_SEXYPOLLING_NAME'),
    			'poll_name' => JText::_('COM_SEXYPOLLING_POLL'),
    			'sa.published' => JText::_('JSTATUS'),
    			'count_votes' => JText::_('COM_SEXYPOLLING_NUM_VOTES'),
    			'sa.id' => JText::_('JGRID_HEADING_ID')
    	);
    }
}