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
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

// no direct access
defined('_JEXEC') or die('Restircted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewSexycategories extends HtmlView {
	
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
 
    	if(JV == 'j3') {
    		JHtmlSidebar::addFilter(
    				Text::_('JOPTION_SELECT_PUBLISHED'),
    				'filter_published',
    				HTMLHelper::_('select.options', HTMLHelper::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
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
    	JToolBarHelper::addNew('sexycategory.add');
    	JToolBarHelper::editList('sexycategory.edit');
	    	
    	JToolBarHelper::divider();
    	JToolBarHelper::publish('sexycategories.publish', 'JTOOLBAR_PUBLISH', true);
    	JToolBarHelper::unpublish('sexycategories.unpublish', 'JTOOLBAR_UNPUBLISH', true);
    	JToolBarHelper::deleteList('', 'sexycategories.delete', 'JTOOLBAR_DELETE');
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
    			'sc.name' => Text::_('COM_SEXYPOLLING_NAME'),
    			'sc.published' => Text::_('JSTATUS'),
    			'sc.id' => Text::_('JGRID_HEADING_ID')
    	);
    }
}