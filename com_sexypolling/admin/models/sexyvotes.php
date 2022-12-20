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
 * @copyright Copyright (c) 2022 Jefferson49
 * @license GNU/GPL v3.0
 * 
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

// Import Joomla! libraries
jimport('joomla.application.component.modellist');

class SexypollingModelSexyVotes extends JModelList {

    /**
     * Constructor.
     *
     * @param   array   An optional associative array of configuration settings.
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id_vote',
                'country',
                'date',
                'city',
                'region',
                'username',
                'id_poll',
                'id_answer',
                'ip'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to get poll list
     *
     */
    public function getSexyPolls() {
        $db = $this->getDbo();
        $sql = "SELECT `id`, `name` FROM `#__sexy_polls` order by `ordering`,`name`";
        $db->setQuery($sql);
        return $opts = $db->loadObjectList();
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @return  void
     * @since   1.6
     */
    protected function populateState($ordering = null, $direction = null)
    {
        // Initialise variables.
        $app = JFactory::getApplication();

        // Adjust the context to support modal layouts.
        if ($layout = JFactory::getApplication()->input->get('layout')) {
            $this->context .= '.'.$layout;
        }

        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $pollId = $this->getUserStateFromRequest($this->context.'.filter.poll_id', 'filter_poll_id');
        $this->setState('filter.poll_id', $pollId);

        // List state information.
        parent::populateState('id_vote', 'desc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string      $id A prefix for the store id.
     *
     * @return  string      A store id.
     * @since   1.6
     */
    protected function getStoreId($id = '')
    {
        // Compile the store id.
        $id .= ':'.$this->getState('filter.search');
        $id .= ':'.$this->getState('filter.poll_id');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return  JDatabaseQuery
     * @since   1.6
     */
    protected function getListQuery()
    {
        // Create a new query object.
        $db     = $this->getDbo();
        $query  = $db->getQuery(true);
        $user   = JFactory::getUser();

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select',
                        'id_vote, id_answer, id_poll, v.id_user, a.name as answer, p.name as poll, username, ip, date, country, city, region'
                )
        );

        $query->from('#__sexy_votes as v');

        $query->join('LEFT', '#__users AS u ON id_user = u.id');

        $query->join('LEFT', '#__sexy_answers AS a ON id_answer = a.id');

        $query->join('LEFT', '#__sexy_polls AS p ON a.id_poll = p.id');

        // Filter by search in name.
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            $search = $db->Quote('%'.$db->escape($search, true).'%');
            $query->where('(ip LIKE '.$search.' or country like '.$search.' or city like '.$search.' or region like '.$search.' or a.name like '.$search.' or p.name like '.$search.' or username like '.$search.')');
        }

        // Filter by a single or group of categories.
        $pollId = $this->getState('filter.poll_id');
        if (is_numeric($pollId)) {
            $query->where('id_poll = '.(int) $pollId);
        }

        // Add the list ordering clause.
        $orderCol   = $this->state->get('list.ordering', 'id_vote');
        $orderDirn  = $this->state->get('list.direction', 'desc');
        $query->order($db->escape($orderCol.' '.$orderDirn));

        return $query;
    }
}
