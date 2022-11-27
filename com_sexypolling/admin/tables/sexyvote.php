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

// import Joomla table library
jimport('joomla.database.table');

class SexyPollTableSexyVote extends JTable
{
    /**
     * Constructor
     *
     * @param object Database connector object
     */
    function __construct(&$db)
    {
        parent::__construct('#__sexy_votes', 'id_vote', $db);
    }
}
