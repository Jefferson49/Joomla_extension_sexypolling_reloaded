<?php
/**
 * Joomla! component sexypolling
 *
 * @version $Id: sexyanswers.php 2012-04-05 14:30:25 svn $
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

class SexypollingModelSexyAnswers extends JModelList {

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
                    'id', 'sa.id',
                    'name', 'sa.name',
                    'poll_name',
                    'poll_id',
                    'count_votes',
                    'published', 'sa.published',
                    'ordering', 'sa.ordering',
                    'publish_up', 'sa.publish_up',
                    'publish_down', 'sa.publish_down'
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to get category options
     *
     */
    public function getSexyPolls() {
        $db     = $this->getDbo();
        $sql = "SELECT `id`, `name` FROM `#__sexy_polls` WHERE `published` <> '-2' order by `ordering`,`name` ";
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

        $access = $this->getUserStateFromRequest($this->context.'.filter.access', 'filter_access', 0, 'int');
        $this->setState('filter.access', $access);

        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        $pollId = $this->getUserStateFromRequest($this->context.'.filter.poll_id', 'filter_poll_id');
        $this->setState('filter.poll_id', $pollId);

        $language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '');
        $this->setState('filter.language', $language);

        // List state information.
        parent::populateState('sa.name', 'asc');
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
        $id .= ':'.$this->getState('filter.published');
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
                        'sa.id, sa.name, sa.published, sa.ordering'.
                        ', sa.publish_up, sa.publish_down'
                )
        );

        $query->from('#__sexy_answers AS sa');

        // get only published polls answers
        $query->join('LEFT', '#__sexy_polls AS sp1 ON sp1.id=sa.id_poll AND sp1.published <> -2');

        // Join over the answers.
        $query->select('COUNT(sv.id_answer) AS count_votes');
        $query->join('LEFT', '#__sexy_votes AS sv ON sv.id_answer=sa.id');

        // Join over the categories.
        $query->select('sp.name AS poll_name,sp.id AS poll_id');
        $query->join('LEFT', '#__sexy_polls AS sp ON sp.id=sa.id_poll');

        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('sa.published = ' . (int) $published);
        }
        elseif ($published === '') {
            $query->where('(sa.published = 0 OR sa.published = 1)');
        }

        // Filter by a single or group of categories.
        $pollId = $this->getState('filter.poll_id');
        if (is_numeric($pollId)) {
            $query->where('sa.id_poll = '.(int) $pollId);
        }
        elseif (is_array($pollId)) {
            \Joomla\Utilities\ArrayHelper::toInteger($pollId);
            $pollId = implode(',', $pollId);
            $query->where('sa.id_poll IN ('.$pollId.')');
        }

        // Filter by search in name.
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('sa.id = '.(int) substr($search, 3));
            }
            else {
                $search = $db->Quote('%'.$db->escape($search, true).'%');
                $query->where('(sa.name LIKE '.$search.')');
            }
        }

        // Add the list ordering clause.
        $orderCol   = $this->state->get('list.ordering', 'sa.name');
        $orderDirn  = $this->state->get('list.direction', 'asc');
        /*
            if ($orderCol == 'a.ordering' || $orderCol == 'category_title') {
        $orderCol = 'c.title '.$orderDirn.', a.ordering';
        }
        */
        $query->order($db->escape($orderCol.' '.$orderDirn));
        $query->group('sa.id');

        //echo nl2br(str_replace('#__','jos_',$query));
        return $query;
    }
}
