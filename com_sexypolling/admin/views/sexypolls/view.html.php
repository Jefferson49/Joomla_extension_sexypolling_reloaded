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
 * @copyright Copyright (c) 2022 - 2023 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

// no direct access
defined('_JEXEC') or die('Restircted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');


class SexypollingViewSexypolls extends HtmlView {
	
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
    	$category_options	= $this->get('category_options');
 
    	//get category options
    	$options        = array();
    	foreach($category_options AS $category) {
    		$options[]      = HTMLHelper::_('select.option', $category->id, $category->name);
    	}
       	if(JV == 'j2') {
	    	$this->category_options = $options;
       	}
       	else {
       		JHtmlSidebar::addFilter(
       				Text::_('JOPTION_SELECT_PUBLISHED'),
       				'filter_published',
       				HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
       		);
       		
       		JHtmlSidebar::addFilter(
       				Text::_('JOPTION_SELECT_CATEGORY'),
       				'filter_category_id',
       				HTMLHelper::_('select.options', $options, 'value', 'text', $this->state->get('filter.category_id'))
       		);
       		
       		JHtmlSidebar::addFilter(
       				Text::_('JOPTION_SELECT_ACCESS'),
       				'filter_access',
       				HTMLHelper::_('select.options', HTMLHelper::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
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
		JToolBarHelper::addNew('sexypoll.add');
		JToolBarHelper::editList('sexypoll.edit');
		    	
		JToolBarHelper::divider();
		JToolBarHelper::publish('sexypolls.publish', 'JTOOLBAR_PUBLISH', true);
		JToolBarHelper::unpublish('sexypolls.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		JToolBarHelper::divider();
		JToolBarHelper::archiveList('sexypolls.archive');
		JToolBarHelper::checkin('sexypolls.checkin');
    	JToolBarHelper::deleteList('', 'sexypolls.delete', 'JTOOLBAR_DELETE');
	    
		JToolBarHelper::divider();
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
				'sp.ordering' => Text::_('JGRID_HEADING_ORDERING'),
				'sp.name' => Text::_('COM_SEXYPOLLING_NAME'),
				'sp.question' => Text::_('COM_SEXYPOLLING_QUESTION'),
				'sp.published' => Text::_('JSTATUS'),
				'category_title' => Text::_('JCATEGORY'),
				'template_title' => Text::_('COM_SEXYPOLLING_TEMPLATE'),
				'sp.featured' => Text::_('JFEATURED'),
				'sp.access' => Text::_('JGRID_HEADING_ACCESS'),
				'num_answers' => Text::_('COM_SEXYPOLLING_NUM_ANSWERS'),
				'sp.id' => Text::_('JGRID_HEADING_ID')
		);
	}
}