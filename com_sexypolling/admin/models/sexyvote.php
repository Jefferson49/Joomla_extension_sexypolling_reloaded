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

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;

// no direct access
defined('_JEXEC') or die('Restircted access');

class SexypollingModelSexyVote extends AdminModel
{
    /**
     * Returns a reference to the a Table object, always creating it.
     *
     * @param   string  The table type to instantiate
     * @param   string  A prefix for the table class name. Optional.
     * @param   array   Configuration array for model. Optional.
     * @return  Table   A database object
     * @since   1.6
     */
    public function getTable($type = 'SexyVote', $prefix = 'SexyPollTable', $config = array())
    {
        return Table::getInstance($type, $prefix, $config);
    }
    /**
     * Method to get the record form.
     *
     * @param   array   $data       Data for the form.
     * @param   boolean $loadData   True if the form is to load its own data (default case), false if not.
     * @return  mixed   A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm('com_sexypolling.sexyvote', 'sexyvote', array('control' => 'jform', 'load_data' => $loadData));
        if (empty($form))
        {
            return false;
        }
        return $form;
    }
    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed   The data for the form.
     * @since   1.6
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = Factory::getApplication()->getUserState('com_sexypolling.edit.sexyvote.data', array());
        if (empty($data))
        {
            $data = $this->getItem();
        }
        return $data;
    }
}