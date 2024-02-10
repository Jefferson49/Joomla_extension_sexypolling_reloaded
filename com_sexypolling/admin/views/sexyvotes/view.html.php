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
 * Extended by:
 * @version v3.0.0
 * @author Jefferson49
 * @link https://github.com/Jefferson49/Joomla_plugin_sexypolling_reloaded
 * @copyright Copyright (c) 2022 - 2024 Jefferson49
 * @license GNU/GPL v3.0
 * 
 * @todo J4 deprecated JHtmlSidebar 
 */

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingViewSexyvotes extends HtmlView {

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
            $options[] = HTMLHelper::_('select.option', $poll->id, $poll->name);
        }

		JHtmlSidebar::addFilter(
				Text::_('COM_SEXYPOLLING_SELECT_POLL'),
				'filter_poll_id',
				HTMLHelper::_('select.options', $options, 'value', 'text', $this->state->get('filter.poll_id'))
		);

        $this->addToolbar();
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

        //Get user and params
        $application = Factory::getApplication();
        $user = $application->getIdentity();

        if ($application->isClient('site')) {
            $params = $application->getParams('com_sexypolling');
        } else {
            $params = ComponentHelper::getParams('com_sexypolling');
        }

        //If permission control for votes/answers is activated, check permission for user
        if ($params->get('permission_control_for_answers_and_votes', 0)) {
            $show_votes   = $user !== null && $user->authorise('core.view.votes', 'com_sexypolling');
        } else {
            $show_votes   = true;
        }

        //If permission to show votes (and related answers), include export for votes
        if($show_votes) {
            JToolBarHelper::divider();
            JToolBarHelper::custom( 'votesexport.runexport', 'new', 'new', Text::_('COM_SEXYPOLLING_VOTES_EXPORT'), false, false );     
        }

        JToolBarHelper::divider();
		JToolBarHelper::preferences('com_sexypolling');
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
                'id_vote' => Text::_('JGRID_HEADING_ID'),
                'date' => Text::_('JDATE'),
                'country' => Text::_('COM_SEXYPOLLING_COUNTRY'),
                'city' => Text::_('COM_SEXYPOLLING_CITY'),
                'region' => Text::_('COM_SEXYPOLLING_REGION'),
                'ip' => Text::_('COM_SEXYPOLLING_IP'),
                'id_answer' => Text::_('COM_SEXYPOLLING_ANSWER'),
                'id_poll' => Text::_('COM_SEXYPOLLING_POLL'),
                'username' => Text::_('COM_SEXYPOLLING_USER')
        );
    }
}