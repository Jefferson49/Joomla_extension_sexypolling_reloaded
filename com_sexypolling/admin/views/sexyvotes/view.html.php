<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id$
 * @author 2GLux.com
 * @package Sexy Polling
 * @subpackage com_sexypolling
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// Import Joomla! libraries
jimport( 'joomla.application.component.view');

class SexypollingViewSexyvotes extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     *
     * @return  void
     */
    public function display($tpl = null) {

        $this->items        = $this->get('Items');
        $this->pagination   = $this->get('Pagination');
        $this->state        = $this->get('State');

        $options = array();
        $polls  = $this->get('sexyPolls');
        foreach($polls AS $poll) {
            $options[] = JHtml::_('select.option', $poll->id, $poll->name);
        }

        if(JV == 'j3') {
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
     * @since   1.6
     */
    protected function addToolbar()
    {
        JToolBarHelper::deleteList('', 'sexyvotes.delete', 'JTOOLBAR_DELETE');
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
                'id_vote' => JText::_('JGRID_HEADING_ID'),
                'date' => JText::_('JDATE'),
                'country' => JText::_('COM_SEXYPOLLING_COUNTRY'),
                'city' => JText::_('COM_SEXYPOLLING_CITY'),
                'region' => JText::_('COM_SEXYPOLLING_REGION'),
                'ip' => JText::_('COM_SEXYPOLLING_IP'),
                'id_answer' => JText::_('COM_SEXYPOLLING_ANSWER'),
                'id_poll' => JText::_('COM_SEXYPOLLING_POLL'),
                'username' => JText::_('COM_SEXYPOLLING_USER')
        );
    }
}