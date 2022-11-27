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

jimport('joomla.application.component.controlleradmin');

class SexyPollingControllerSexyVotes extends JControllerAdmin
{
    /**
     * Constructor.
     *
     * @param   array   $config An optional associative array of configuration settings.
     *
     * @return  ContactControllerContacts
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    /**
     * Proxy for getModel.
     *
     * @param   string  $name   The name of the model.
     * @param   string  $prefix The prefix for the PHP class name.
     *
     * @return  JModel
     * @since   1.6
     */
    public function getModel($name = 'sexyvote', $prefix = 'SexyPollingModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }
}
